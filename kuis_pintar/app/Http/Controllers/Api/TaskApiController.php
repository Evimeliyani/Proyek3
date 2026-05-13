<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;

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
}
