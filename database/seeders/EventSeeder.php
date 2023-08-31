<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Organizer;
use Faker\Factory as Faker;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $organizers = Organizer::all()->pluck('id')->toArray();

    foreach (range(1,15) as $index) {
        Event::create([
            'title' => $faker->sentence,
            'description' => $faker->paragraph,
            'event_image_path' => $faker->imageUrl(),
            'organizer_id' => $faker->randomElement($organizers),
            'start_date' => $faker->dateTimeBetween('now', '+1 month'),
            'end_date' => $faker->dateTimeBetween('+1 month', '+2 months'),
            'start_time' => $faker->time(),
            'end_time' => $faker->time(),
            'name' => $faker->name,
            'city' => $faker->city,
            'street' => $faker->streetAddress,
            'building' => $faker->buildingNumber,
            'zip_code' => $faker->postcode,
        ]);
    }
    }
}
