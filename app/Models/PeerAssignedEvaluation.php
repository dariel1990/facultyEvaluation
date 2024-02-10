<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeerAssignedEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty_id',
        'evaluation_id',
        'hasCompleted',
        'comment'
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculties::class, 'faculty_id', 'id');
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class, 'evaluation_id', 'id');
    }
}
