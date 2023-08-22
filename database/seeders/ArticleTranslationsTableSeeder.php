<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Language;
use App\Models\ArticleTranslation;
use Faker\Factory as Faker;

class ArticleTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $articles = Article::all();
        $languages = Language::all();

        foreach ($articles as $article) {
            foreach ($languages as $language) {
                ArticleTranslation::create([
                    'article_id' => $article->id,
                    'language_id' => $language->id,
                    'title' => $faker->sentence,
                    'content' => $faker->paragraph
                ]);
            }
        }
    }
}
