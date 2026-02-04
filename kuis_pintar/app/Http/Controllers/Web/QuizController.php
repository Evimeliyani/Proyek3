<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Quiz;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::orderBy('id')->get();
        return view('web.quiz.index', compact('quizzes'));
    }

    public function show(string $slug)
    {
        $quiz = Quiz::where('slug', $slug)->firstOrFail();
        $questions = $quiz->questions()->orderBy('id')->get();

        return view('web.quiz.show', compact('quiz', 'questions'));
    }
}
