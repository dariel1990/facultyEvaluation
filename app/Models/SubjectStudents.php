<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SubjectStudents extends Pivot
{
    use HasFactory;

    public $table = 'subject_students';

    protected $fillable = [
        'subject_id',
        'student_id',
    ];

    public function students()
    {
        return $this->belongsTo(Students::class, 'student_id');
    }

    public function subjects()
    {
        return $this->belongsTo(Subjects::class, 'subject_id');
    }
}
