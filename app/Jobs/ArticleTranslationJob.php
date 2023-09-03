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
    public function handle(): void
    {
        $languages = Language::all();
        $client = new Client();

        foreach ($languages as $language) {
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
                                'content' => "You are a helpful assistant that translates Japanese to {$language->name}.",
                            ],
                            [
                                'role' => 'user',
                                'content' => $this->article->content,
                            ],
                        ],
                    ],
                ]);

                $response_json = json_decode($response->getBody(), true);

                if (isset($response_json['error'])) {
                    Log::error('OpenAI API error: ' . $response_json['error']['message']);
                    continue;
                }

                $translated_content = $response_json['choices'][0]['message']['content'];

                
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
                                'content' => "You are a helpful assistant that translates Japanese to {$language->name}.",
                            ],
                            [
                                'role' => 'user',
                                'content' => $this->article->title,
                            ],
                        ],
                    ],
                ]);

                $response_json = json_decode($response->getBody(), true);

                if (isset($response_json['error'])) {
                    Log::error('OpenAI API error: ' . $response_json['error']['message']);
                    continue;
                }

                $translated_title = $response_json['choices'][0]['message']['content'];

                ArticleTranslation::updateOrCreate(
                    ['article_id' => $this->article->id, 'language_id' => $language->id],
                    ['title' => $translated_title, 'content' => $translated_content]
                );
            } catch (\Exception $e) {

                Log::error('Exception encountered while translating article: ' . $e->getMessage());
            }
            }
        }
}
