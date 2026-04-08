<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthMobileController;
use App\Http\Controllers\Api\QuizController;

Route::get('/quiz', [QuizController::class, 'index']);
Route::get('/quiz/{id}/questions', [QuizController::class, 'questions']);

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthMobileController::class, 'login']);
    Route::post('/register', [AuthMobileController::class, 'register']);

    Route::post('/logout', [AuthMobileController::class, 'logout'])
        ->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return response()->json([
        'user' => $request->user()
    ]);
});
