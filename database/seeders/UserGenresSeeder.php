<?php

namespace Database\Seeders;

use App\Models\UserGenre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Genre;

class UserGenresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $genres = Genre::all();

        foreach ($users as $user) {
            $selectedGenres = $genres->random(rand(1, 3));
            foreach ($selectedGenres as $genre) {
                UserGenre::create([
                    'user_id' => $user->id,
                    'genre_id' => $genre->id
                ]);
            }
        }
    }
}
