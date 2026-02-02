<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthWebController;

Route::get('/login', [AuthWebController::class, 'showLogin'])->name('web.login');
Route::post('/login', [AuthWebController::class, 'submitLogin'])->name('web.login.submit');
Route::post('/logout', [AuthWebController::class, 'logout'])->name('web.logout');

Route::get('/dashboard', function () {
    return view('web.dashboard');
})->middleware('auth')->name('web.dashboard');
