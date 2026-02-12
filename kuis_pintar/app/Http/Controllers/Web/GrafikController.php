<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GrafikController extends Controller
{
    public function index()
    {
        // Ambil daftar user yang punya nilai quiz (distinct user_id)
        $users = DB::table('users')
            ->join('quiz_results', 'users.id', '=', 'quiz_results.user_id')
            ->where('users.role', '!=', 'guru')   // <= ini
            ->select('users.id', 'users.name')
            ->distinct()
            ->orderBy('users.name')
            ->get();


        return view('web.grafik.index', compact('users'));
    }

    public function show($userId)
    {
        $user = DB::table('users')->where('id', $userId)->first();
        abort_if(!$user, 404);

        // Ambil rata-rata score per kategori dari quiz_results (TANPA join quizzes)
        $rows = DB::table('quiz_results')
            ->select('kategori', DB::raw('AVG(score) as avg_score'))
            ->where('user_id', $userId)
            ->groupBy('kategori')
            ->orderBy('kategori')
            ->get();

        // Kalau user belum punya data
        if ($rows->isEmpty()) {
            return view('web.grafik.show', [
                'user' => $user,
                'labels' => [],
                'data' => [],
                'aiInsight' => 'Belum ada data nilai untuk siswa ini.',
            ]);
        }

        $labels = $rows->pluck('kategori')->values();
        $data   = $rows->pluck('avg_score')->map(fn ($v) => round((float)$v, 1))->values();

        // "AI" sederhana (biar aman, tidak panggil API dulu)
        // Nanti kalau mau pakai OpenAI beneran, tinggal ganti bagian ini.
        $maxIndex = $data->search($data->max());
        $minIndex = $data->search($data->min());

        $best = $labels[$maxIndex] ?? '-';
        $worst = $labels[$minIndex] ?? '-';

        $aiInsight = "Analisis AI: Kategori terkuat **{$best}**. "
            . "Kategori yang perlu latihan tambahan **{$worst}**. "
            . "Saran: lakukan latihan rutin 10–15 menit/hari pada kategori terendah.";

        return view('web.grafik.show', compact('user', 'labels', 'data', 'aiInsight'));
    }
}
