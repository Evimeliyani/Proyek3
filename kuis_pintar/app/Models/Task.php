<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = [
        'guru_id',
        'kategori',
        'judul',
        'soal',
        'kunci_jawaban',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
