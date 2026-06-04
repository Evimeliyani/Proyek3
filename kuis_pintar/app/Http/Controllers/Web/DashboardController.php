<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\User;
use App\Models\QuizResult;

class DashboardController extends Controller
{
    public function index()
    {
        $totalQuiz = Quiz::count();
        $totalMurid = User::count();
        $kategori = 4;

        $grafik = QuizResult::selectRaw('kategori, AVG(score) as rata_rata')
            ->groupBy('kategori')
            ->pluck('rata_rata', 'kategori');

        $penjumlahan = round($grafik['Penjumlahan'] ?? 0, 2);
        $pengurangan = round($grafik['Pengurangan'] ?? 0, 2);
        $perkalian   = round($grafik['Perkalian'] ?? 0, 2);
        $pembagian   = round($grafik['Pembagian'] ?? 0, 2);

        return view('web.dashboard', compact(
            'totalQuiz',
            'totalMurid',
            'kategori',
            'penjumlahan',
            'pengurangan',
            'perkalian',
            'pembagian'
        ));
    }
}