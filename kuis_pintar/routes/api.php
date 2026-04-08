<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthMobileController;

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
