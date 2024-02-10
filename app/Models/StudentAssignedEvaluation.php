<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAssignedEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'evaluation_id',
        'hasCompleted',
        'comment'
    ];

    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id', 'id');
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class, 'evaluation_id', 'id');
    }
}
