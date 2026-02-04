<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(Request $request, string $slug)
    {
        $quiz = Quiz::where('slug', $slug)->firstOrFail();

        $data = $request->validate([
            'question' => 'required|string|max:255',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_option' => 'required|in:A,B,C,D',
            'level' => 'required|in:Mudah,Sedang,Sulit',
        ]);

        $data['quiz_id'] = $quiz->id;

        Question::create($data);

        return redirect()->route('web.quiz.show', $quiz->slug)->with('success', 'Soal berhasil ditambahkan.');
    }

    public function update(Request $request, int $id)
    {
        $question = Question::findOrFail($id);

        $data = $request->validate([
            'question' => 'required|string|max:255',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_option' => 'required|in:A,B,C,D',
            'level' => 'required|in:Mudah,Sedang,Sulit',
        ]);

        $question->update($data);

        $quiz = $question->quiz;
        return redirect()->route('web.quiz.show', $quiz->slug)->with('success', 'Soal berhasil diupdate.');
    }

    public function destroy(int $id)
    {
        $question = Question::findOrFail($id);
        $quiz = $question->quiz;

        $question->delete();

        return redirect()->route('web.quiz.show', $quiz->slug)->with('success', 'Soal berhasil dihapus.');
    }
}
