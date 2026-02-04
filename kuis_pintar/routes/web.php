<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\QuizController;
use App\Http\Controllers\Web\QuestionController;

Route::get('/login', [AuthWebController::class, 'showLogin'])->name('web.login');
Route::post('/login', [AuthWebController::class, 'submitLogin'])->name('web.login.submit');
Route::post('/logout', [AuthWebController::class, 'logout'])->name('web.logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('web.dashboard');

    Route::get('/quiz', [QuizController::class, 'index'])->name('web.quiz.index');
    Route::get('/quiz/{slug}', [QuizController::class, 'show'])->name('web.quiz.show');

    Route::post('/quiz/{slug}/questions', [QuestionController::class, 'store'])->name('web.quiz.questions.store');
    Route::put('/quiz/questions/{id}', [QuestionController::class, 'update'])->name('web.quiz.questions.update');
    Route::delete('/quiz/questions/{id}', [QuestionController::class, 'destroy'])->name('web.quiz.questions.destroy');

});
