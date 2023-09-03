<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\Organizer;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $organizers = Organizer::all()->pluck('id')->toArray();
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'event_image_path' => $this->faker->imageUrl(),
            'organizer_id' => $this->faker->randomElement($organizers),
            'start_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'end_date' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'start_time' => $this->faker->time(),
            'end_time' => $this->faker->time(),
            'name' => $this->faker->name,
            'city' => $this->faker->city,
            'street' => $this->faker->streetAddress,
            'building' => $this->faker->buildingNumber,
            'zip_code' => $this->faker->postcode,
        ];
    }
}
