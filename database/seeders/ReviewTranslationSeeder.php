<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Language;
use App\Models\ReviewTranslation;
use Faker\Factory as Faker;

class ReviewTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $reviews = Review::all()->pluck('id')->toArray();
        $languages = Language::all()->pluck('id')->toArray();

        foreach (range(1, 10) as $index) {
            ReviewTranslation::create([
                'review_id' => $faker->randomElement($reviews),
                'language_id' => $faker->randomElement($languages),
                'comment' => $faker->paragraph,
            ]);
        }
    }
}
