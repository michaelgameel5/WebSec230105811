<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        Question::insert([
            [
                'text' => 'What is the capital of France?',
                'options' => json_encode(['Paris', 'London', 'Berlin', 'Madrid']),
                'correct_answer' => 'Paris',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'text' => 'Which planet is known as the Red Planet?',
                'options' => json_encode(['Earth', 'Mars', 'Jupiter', 'Venus']),
                'correct_answer' => 'Mars',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
