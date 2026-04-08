<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::select('id', 'title', 'slug')->get();

        return response()->json([
            'data' => $quizzes
        ]);
    }

    public function questions($id)
    {
        $questions = Question::where('quiz_id', $id)->get();

        return response()->json([
            'data' => $questions
        ]);
    }
}
