<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupervisorAssignedEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'supervisor_id',
        'evaluation_id',
        'hasCompleted',
        'comment'
    ];

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class, 'supervisor_id', 'id');
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class, 'evaluation_id', 'id');
    }
}
