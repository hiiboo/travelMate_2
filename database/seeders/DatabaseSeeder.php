<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\Organizer::factory(4)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            OrganizerSeeder::class,
            LanguagesTableSeeder::class,
            UserSeeder::class,
            GenresTableSeeder::class,
            EventSeeder::class,
            EventTranslationSeeder::class,
            ReviewSeeder::class,
            ReviewTranslationSeeder::class,
            ArticlesTableSeeder::class,
            EventGenreSeeder::class,
            ArticleGenresTableSeeder::class,
            ArticleTranslationsTableSeeder::class,
            ArticleImagesTableSeeder::class, 
            UserGenresSeeder::class,
            ParticipationSeeder::class,
            
        ]);
    }
}
