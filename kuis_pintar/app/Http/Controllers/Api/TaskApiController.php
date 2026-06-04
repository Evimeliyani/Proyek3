<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskApiController extends Controller
{
    // AMBIL SEMUA TUGAS BERDASARKAN KATEGORI
    public function getTasks($kategori)
    {
        $tasks = Task::where(
                'kategori',
                $kategori
            )
            ->where('is_active', 1)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $tasks
        ]);
    }

    // RIWAYAT PENGERJAAN TUGAS SISWA
    public function history(Request $request)
    {
        $siswaId = $request->user()->id;

        $history = DB::table('tugas_submissions')
            ->join(
                'tugas',
                'tugas.id',
                '=',
                'tugas_submissions.tugas_id'
            )
            ->where(
                'tugas_submissions.siswa_id',
                $siswaId
            )
            ->select(
                'tugas.judul',
                'tugas.kategori',
                'tugas.soal',
                'tugas_submissions.nilai',
                'tugas_submissions.jawaban_ocr',
                'tugas_submissions.photo_path',
                'tugas_submissions.submitted_at'
            )
            ->orderByDesc('tugas_submissions.id')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $history
        ]);
    }
}