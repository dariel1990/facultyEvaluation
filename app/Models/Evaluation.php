<?php

namespace App\Models;

use App\Models\Faculties;
use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evaluation extends Model
{
    use HasFactory;

    public $table = 'evaluations';

    protected $fillable = [
        'academic_id',
        'faculty_id',
        'type',
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_id', 'id');
    }

    public function faculty()
    {
        return $this->hasOne(Faculties::class, 'id', 'faculty_id');
    }

    public function studentAssigned()
    {
        return $this->hasMany(StudentAssignedEvaluation::class, 'evaluation_id', 'id');
    }

    public function peerAssigned()
    {
        return $this->hasMany(PeerAssignedEvaluation::class, 'evaluation_id', 'id');
    }

    public function supervisorAssigned()
    {
        return $this->hasMany(SupervisorAssignedEvaluation::class, 'evaluation_id', 'id');
    }
}
