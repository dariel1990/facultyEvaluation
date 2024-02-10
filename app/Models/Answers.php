<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    use HasFactory;

    public $table = 'answers';

    protected $fillable = [
        'user_id',
        'evaluation_id',
        'question_id',
        'rate',
    ];

    public function question()
    {
        return $this->belongsTo(Questions::class, 'question_id', 'id');
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class, 'evaluation_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
