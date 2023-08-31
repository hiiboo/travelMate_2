<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Article;
use App\Models\Organizer;
use App\Models\Event;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $organizers = Organizer::all();
        $events = Event::all()->pluck('id')->toArray();
        foreach (range(1, 10) as $index) {
            Article::create([
                'organizer_id' => $faker->randomElement($organizers)->id,
                'title' => $faker->sentence,
                'event_id' => $faker->randomElement($events),
                'content' => $faker->paragraph,
                'status' => $faker->randomElement(['DRAFT', 'PUBLISHED', 'ARCHIVED']),
            ]);
        }
    }
}
