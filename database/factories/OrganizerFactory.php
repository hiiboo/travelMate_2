<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organizer>
 */
class OrganizerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), 
            'city' => $this->faker->city,
            'state' => $this->faker->prefecture,
            'zip_code' => $this->faker->postcode,
            'bio' => $this->faker->paragraph,
            'image_path' => 'path/to/image.jpg', 
        ];
    }
}
