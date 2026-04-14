<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    protected $table = 'quiz_results';

    protected $fillable = [
        'user_id',
        'kategori',
        'score',
        'taken_at',
    ];
}
