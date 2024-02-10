<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    public $table = 'classes';

    protected $fillable = [
        'academic_id',
        'class_code',
        'course',
        'year_level',
        'section',
    ];

    public function subjects()
    {
        return $this->hasMany(Subjects::class, 'class_id', 'id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_id', 'id');
    }
}
