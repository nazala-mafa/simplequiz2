<?php

namespace Database\Seeders;

use App\Models\AnswerModel;
use App\Models\QuestionModel;
use App\Models\TestModel;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TestModel::factory(5)->create()->each(function($test) {
            QuestionModel::factory(10)->create([
                'test_id' => $test->id
            ])->each(function($question) {
                AnswerModel::factory(1)->create([
                    'text' => fake()->sentence(fake()->numberBetween(8, 12)) . ' - true',
                    'is_true' => true,
                    'question_id' => $question->id
                ]);
                AnswerModel::factory(4)->create([
                    'text' => fake()->sentence(fake()->numberBetween(8, 12)),
                    'is_true' => false,
                    'question_id' => $question->id
                ]);

            });
        });
    }
}
