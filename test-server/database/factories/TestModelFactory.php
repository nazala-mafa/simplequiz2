<?php

namespace Database\Factories;

use App\Models\QuestionModel;
use App\Models\TestModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TestModelFactory extends Factory
{
    protected $model = TestModel::class;
    
    public function definition()
    {
        return [
            'title' => fake()->sentence(fake()->numberBetween(7, 13)),
            'desc' => fake()->sentence(fake()->numberBetween(15, 24)),
            'user_id' => 1
        ];
    }
}
