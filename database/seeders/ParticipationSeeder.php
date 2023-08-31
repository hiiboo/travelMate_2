<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Participation;
use App\Models\User;
use App\Models\Event;
use Faker\Factory as Faker;


class ParticipationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::all()->pluck('id')->toArray();
        $events = Event::all()->pluck('id')->toArray();

        foreach (range(1, 10) as $index) {
            Participation::create([
                'user_id' => $faker->randomElement($users),
                'event_id' => $faker->randomElement($events),
            ]);
        }
    }
}
