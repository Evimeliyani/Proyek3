<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    protected $fillable = [
        'user_id', 'kategori', 'score', 'taken_at',
    ];

    protected $casts = [
        'taken_at' => 'datetime',
    ];
}
