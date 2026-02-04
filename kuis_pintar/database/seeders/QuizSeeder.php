<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['title' => 'Penjumlahan', 'slug' => 'penjumlahan', 'banner_path' => 'images/quiz-header.png'],
            ['title' => 'Pengurangan', 'slug' => 'pengurangan', 'banner_path' => 'images/quiz-header.png'],
            ['title' => 'Perkalian', 'slug' => 'perkalian', 'banner_path' => 'images/quiz-header.png'],
            ['title' => 'Pembagian', 'slug' => 'pembagian', 'banner_path' => 'images/quiz-header.png'],
        ];

        foreach ($items as $it) {
            Quiz::updateOrCreate(['slug' => $it['slug']], $it);
        }
    }
}
