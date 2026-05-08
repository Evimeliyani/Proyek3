<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class QuizResult extends Model
{
    protected $table = 'quiz_results';

    protected $fillable = [
        'user_id',
        'kategori',
        'score',
        'taken_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
