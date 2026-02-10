<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasSubmission extends Model
{
    protected $fillable = [
        'tugas_id','siswa_id','jawaban_ocr','photo_path','nilai','submitted_at'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function tugas(){
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }

    public function siswa(){
        return $this->belongsTo(User::class, 'siswa_id');
    }
}

