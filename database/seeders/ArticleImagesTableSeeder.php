<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\ArticleImage;
use Faker\Factory as Faker;

class ArticleImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $articles = Article::all();

        foreach ($articles as $article) {
            for ($i = 0; $i < 3; $i++) {
                ArticleImage::create([
                    'article_id' => $article->id,
                    'image_path' => $faker->imageUrl($width = 640, $height = 480), 
                ]);
            }
        }
    }
}
