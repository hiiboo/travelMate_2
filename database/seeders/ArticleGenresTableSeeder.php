<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Genre;
use App\Models\ArticleGenre;

class ArticleGenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = Article::all();
        $genres = Genre::all();

        foreach ($articles as $article) {
            $selectedGenres = $genres->random(rand(1, 3));
            foreach ($selectedGenres as $genre) {
                ArticleGenre::create([
                    'article_id' => $article->id,
                    'genre_id' => $genre->id
                ]);
            }
        }
    }
}
