<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // angka bisa kamu ganti sesuai kebutuhan
        $totalQuiz = Quiz::count();
        $totalMurid = User::count(); // kalau murid beda tabel, ganti nanti
        $kategori = 4; // kalau kamu belum punya tabel kategori, biarin statis

        return view('web.dashboard', compact('totalQuiz', 'totalMurid', 'kategori'));
    }
}
