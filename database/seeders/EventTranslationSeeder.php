<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\EventTranslation;

class EventTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $events = Event::all()->pluck('id')->toArray();
        $languages = Language::all()->pluck('id')->toArray();

        foreach (range(1, 10) as $index) {
            EventTranslation::create([
                'event_id' => $faker->randomElement($events),
                'language_id' => $faker->randomElement($languages),
                'title' => $faker->name,
                'description' => $faker->text,
            ]);
        }
    }
}
