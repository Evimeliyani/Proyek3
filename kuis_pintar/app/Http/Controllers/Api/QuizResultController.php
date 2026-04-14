<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;

class QuizResultController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'quiz_id' => ['required', 'exists:quizzes,id'],
            'score' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $quiz = Quiz::findOrFail($data['quiz_id']);

        $result = QuizResult::create([
            'user_id' => $request->user()->id,
            'kategori' => $quiz->title,
            'score' => $data['score'],
            'taken_at' => now(),
        ]);

        return response()->json([
            'message' => 'Hasil quiz berhasil disimpan',
            'data' => $result,
        ], 201);
    }
}
