<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'title' => fake()->sentence(fake()->numberBetween(12, 15)),
            'body' => fake()->sentence(fake()->numberBetween(80, 100)),
            'posted_at' => fake()->date('Ymd', 'now')
        ];
    }
}
