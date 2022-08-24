<?php

namespace Database\Factories;

use App\Models\QuestionModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class QuestionModelFactory extends Factory
{
    protected $model = QuestionModel::class;
    
    public function definition()
    {
        return [
            'quest' => fake()->sentence(fake()->numberBetween(8, 14))
        ];
    }
}
