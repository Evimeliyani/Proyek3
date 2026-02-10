<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas';

    protected $fillable = [
        'guru_id','kategori','judul','soal','kunci_jawaban','is_active'
    ];

    public function guru(){
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function submissions(){
        return $this->hasMany(TugasSubmission::class, 'tugas_id');
    }
}
