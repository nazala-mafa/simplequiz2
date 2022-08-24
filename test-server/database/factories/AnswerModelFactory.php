<?php

namespace Database\Factories;

use App\Models\AnswerModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AnswerModelFactory extends Factory
{
    protected $model = AnswerModel::class;
    
    public function definition()
    {
        return [
            'text' => fake()->sentence(fake()->numberBetween(8, 12))
        ];
    }
}
