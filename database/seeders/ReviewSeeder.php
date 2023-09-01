<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Event;
use App\Models\User;
use Faker\Factory as Faker;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $events = Event::all()->pluck('id')->toArray();
        $users = User::all()->pluck('id')->toArray();

        foreach (range(1, 10) as $index) {
            Review::create([
                'user_id' => $faker->randomElement($users),
                'event_id' => $faker->randomElement($events),
                'rating' => $faker->numberBetween(1, 5),
                'comment' => $faker->sentence,
            ]);
        }
    }
}
