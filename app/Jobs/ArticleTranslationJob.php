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

    /**
     * Execute the job.
     */
    // public function handle(): void
    // {
    //     Log::info('Start of handle method');
    //     // $languages = Language::all();
    //     $client = new Client();

    // foreach ($languages as $language) {
    //     Log::info('Start of foreach loop');

    public function handle(): void
    {
        $client = new Client();

        $this->translateAndSave($client, 'English');
        $this->translateAndSave($client, 'French');
        $this->translateAndSave($client, 'Spanish');
    }

    private function translateAndSave($client, $languageName)
    {
        Log::info('Start of handle method');
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
                            'content' => $this->article->content,
                        ],
                    ],
                ],
            ]);
            Log::info('After sending request');
            $responseContent = $response->getBody()->getContents();
            Log::info($responseContent);
            $response_json = json_decode($response->getBody(), true);

            if (isset($response_json['error'])) {
                Log::error('OpenAI API error: ' . $response_json['error']['message']);
                return;
            }

            $translated_content = $response_json['choices'][0]['message']['content'];
            Log::info('After getting translated content');
            sleep(4); 
            Log::info('Before sending request');
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
                            'content' => $this->article->title,
                        ],
                    ],
                ],
            ]);
            Log::info('After sending request');
            $responseContent = $response->getBody()->getContents();
            Log::info($responseContent);
            $response_json = json_decode($response->getBody(), true);

            if (isset($response_json['error'])) {
                Log::error('OpenAI API error: ' . $response_json['error']['message']);
                return;
            }

            $translated_title = $response_json['choices'][0]['message']['content'];
            Log::info('After getting translated content');
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

}
