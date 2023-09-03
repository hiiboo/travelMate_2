<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Article;
use App\Models\Language;
use GuzzleHttp\Client;
use App\Models\ArticleTranslation;
use Illuminate\Support\Facades\Log;

class ArticleTranslationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $article;

    /**
     * Create a new job instance.
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function handle(): void
    {
        $client = new Client();
        $languages = Language::all();
        Log::info('Translating article id: ' . $this->article->id);

        foreach ($languages as $language) {
            Log::info('Translating to: ' . $language->name);
            $this->translateAndSave($client, $language->name);
        }
    }

    private function translateAndSave($client, $languageName)
    {
        try {
            // Translating content
            Log::info('Sending request to translate content');
            $response = $this->sendRequest($client, $languageName, $this->article->content);
            $translated_content = $this->getTranslatedContent($response);

            // Translating title
            Log::info('Sending request to translate title');
            $response = $this->sendRequest($client, $languageName, $this->article->title);
            $translated_title = $this->getTranslatedContent($response);

            // Saving translation
            Log::info('Saving translation');
            $language = Language::where('name', $languageName)->first();
            ArticleTranslation::updateOrCreate(
                ['article_id' => $this->article->id, 'language_id' => $language->id],
                ['title' => $translated_title, 'content' => $translated_content]
            );
        } catch (\Exception $e) {
            Log::error('Exception encountered while translating article: ' . $e->getMessage());
        }
        sleep(4);
    }

    private function sendRequest($client, $languageName, $content)
    {
        try {
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . config('services.openai.api_key'),
                ],
                'json' => [
                    'model' => "gpt-3.5-turbo",
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => "You are a helpful assistant that translates Japanese to {$languageName}.",
                        ],
                        [
                            'role' => 'user',
                            'content' => $content,
                        ],
                    ],
                ],
            ]);
            Log::info('Request sent');
            return $response;
        } catch (\Exception $e) {
            Log::error('Exception encountered while sending request: ' . $e->getMessage());
            throw $e;
        }
    }

    private function getTranslatedContent($response)
    {
        try {
            $responseContent = $response->getBody()->getContents();
            $response_json = json_decode($response->getBody(), true);

            if (isset($response_json['error'])) {
                Log::error('OpenAI API error: ' . $response_json['error']['message']);
                throw new \Exception('OpenAI API error: ' . $response_json['error']['message']);
            }

            $translated_content = $response_json['choices'][0]['message']['content'];
            Log::info('Translated content received');
            return $translated_content;
        } catch (\Exception $e) {
            Log::error('Exception encountered while receiving translated content: ' . $e->getMessage());
            throw $e;
        }
    }
}
