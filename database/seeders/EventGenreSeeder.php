<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventGenre;  
use App\Models\Event;
use App\Models\Genre;

class EventGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Event::all();
        $genres = Genre::all();

        foreach ($events as $event) {
            $selectedGenres = $genres->random(rand(1, 3));
            foreach ($selectedGenres as $genre) {
                EventGenre::create([
                    'event_id' => $event->id,
                    'genre_id' => $genre->id
                ]);
            }
        }
    }
}
