<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthMobileController;

Route::prefix('auth')->group(function () {
    // register khusus siswa mobile
    Route::post('/register', [AuthMobileController::class, 'register']);

    // logout token (hapus token aktif)
    Route::post('/logout', [AuthMobileController::class, 'logout'])
        ->middleware('auth:sanctum');
});

// cek user login berdasarkan token
Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return response()->json([
        'user' => $request->user()
    ]);
});
