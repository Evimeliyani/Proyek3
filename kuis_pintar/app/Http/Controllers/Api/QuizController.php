<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function history(Request $request)
    {
        $data = DB::table('quiz_results')
            ->where('user_id', $request->user()->id)
            ->select('kategori', 'score', 'taken_at')
            ->orderBy('taken_at', 'desc')
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }
}