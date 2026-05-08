<?php

namespace App\Http\Controllers;

use App\Models\QuizResult;

class QuizResultController extends Controller
{
    public function index()
    {
        $results = QuizResult::with('user')
            ->orderBy('taken_at', 'desc')
            ->get();

        return view('web.quiz.result', compact('results'));
    }
}
