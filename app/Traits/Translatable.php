<?php

namespace App\Traits;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

trait Translatable
{
  private function sendRequest(Client $client, string $languageName, string $content)
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

