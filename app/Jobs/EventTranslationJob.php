<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;
use App\Models\Event;
use App\Models\Language;
use App\Models\EventTranslation;
use Illuminate\Support\Facades\Log;
use App\Traits\Translatable;


class EventTranslationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Translatable;

    protected $event;

    /**
     * Create a new job instance.
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function handle(): void
    {
        $client = new Client();
        $languages = Language::all();
        Log::info('Translating event id: ' . $this->event->id);

        foreach ($languages as $language) {
            Log::info('Translating to: ' . $language->name);
            $this->translateAndSave($client, $language->name);
        }
    }

    private function translateAndSave($client, $languageName)
    {
        try {
            // Translating description
            Log::info('Sending request to translate description');
            $response = $this->sendRequest($client, $languageName, $this->event->description);
            $translated_description = $this->getTranslatedContent($response);

            // Translating title
            Log::info('Sending request to translate title');
            $response = $this->sendRequest($client, $languageName, $this->event->title);
            $translated_title = $this->getTranslatedContent($response);

            // Saving translation
            Log::info('Saving translation');
            $language = Language::where('name', $languageName)->first();
            EventTranslation::updateOrCreate(
                ['event_id' => $this->event->id, 'language_id' => $language->id],
                ['title' => $translated_title, 'description' => $translated_description]
            );
        } catch (\Exception $e) {
            Log::error('Exception encountered while translating event: ' . $e->getMessage());
        }
        sleep(4);
    }
}
