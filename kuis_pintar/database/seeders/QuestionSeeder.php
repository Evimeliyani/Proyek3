<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $quiz = Quiz::where('slug', 'penjumlahan')->first();
        if (!$quiz) return;

        $rows = [
            ['question'=>'5 + 9 = ?',   'option_a'=>'12','option_b'=>'13','option_c'=>'14','option_d'=>'15','correct_option'=>'C','level'=>'Mudah'],
            ['question'=>'14 + 15 = ?', 'option_a'=>'28','option_b'=>'29','option_c'=>'30','option_d'=>'31','correct_option'=>'B','level'=>'Sedang'],
            ['question'=>'110 + 10 = ?','option_a'=>'120','option_b'=>'130','option_c'=>'140','option_d'=>'150','correct_option'=>'A','level'=>'Sulit'],
            ['question'=>'35 + 25 = ?', 'option_a'=>'55','option_b'=>'58','option_c'=>'65','option_d'=>'60','correct_option'=>'D','level'=>'Sedang'],
        ];

        foreach ($rows as $r) {
            Question::updateOrCreate(
                ['quiz_id'=>$quiz->id, 'question'=>$r['question']],
                array_merge($r, ['quiz_id'=>$quiz->id])
            );
        }
    }
}
