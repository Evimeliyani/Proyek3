<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthMobileController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\QuizResultController;

Route::middleware('auth:sanctum')->get('/quiz-history', [QuizController::class, 'history']);
/*
|--------------------------------------------------------------------------
| PUBLIC API (tanpa login)
|--------------------------------------------------------------------------
*/

// ambil daftar quiz
Route::get('/quiz', [QuizController::class, 'index']);

// ambil soal berdasarkan quiz
Route::get('/quiz/{id}/questions', [QuizController::class, 'questions']);


/*
|--------------------------------------------------------------------------
| AUTH (login, register, logout)
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {

    Route::post('/login', [AuthMobileController::class, 'login']);
    Route::post('/register', [AuthMobileController::class, 'register']);

    Route::post('/logout', [AuthMobileController::class, 'logout'])
        ->middleware('auth:sanctum');

});


/*
|--------------------------------------------------------------------------
| PROTECTED (HARUS LOGIN / TOKEN)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // ambil data user login
    Route::get('/me', function (Request $request) {
        return response()->json([
            'user' => $request->user()
        ]);
    });

    // ✅ SIMPAN HASIL QUIZ (FITUR BARU)
    Route::post('/quiz-results', [QuizResultController::class, 'store']);

});
