<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'title' => fake()->jobTitle(),
            'address' => fake()->address(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'image_path' => fake()->imageUrl(),
            'user_id' => 1
        ];
    }
}
