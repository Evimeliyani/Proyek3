<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DummyQuizResultSeeder::class,
            QuizSeeder::class,
            QuestionSeeder::class,
        ]);
    }
}
