<?php

namespace App\Models;

use App\Models\Students;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subjects extends Model
{
    use HasFactory;

    public $table = 'subjects';

    protected $fillable = [
        'class_id',
        'subject_code',
        'description',
        'faculty_id',
    ];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class, 'subject_id', 'id');
    }

    public function students()
    {
        return $this->belongsToMany(Students::class, 'subject_students', 'subject_id', 'student_id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculties::class, 'faculty_id', 'id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id', 'id');
    }
}
