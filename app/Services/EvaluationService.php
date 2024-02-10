<?php

namespace App\Services;

use App\Models\Evaluation;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\Validator;

class EvaluationService
{
    public function getAllEvaluations()
    {
        return Evaluation::all();
    }

    public function getEvaluationsForDefaultPeriod($defaultPeriod)
    {
        return Evaluation::with('academicYear', 'faculty')->where('academic_id', $defaultPeriod)->get();
    }

    public function getEvaluationsByType($type, $defaultPeriod)
    {
        return Evaluation::with('faculty', 'faculty.department', 'studentAssigned', 'peerAssigned', 'supervisorAssigned')
                            ->where('type', $type)
                            ->where('academic_id', $defaultPeriod)
                            ->get();
    }

    public function getEvaluationById($id)
    {
        return Evaluation::with(['faculty', 'faculty.department', 'academicYear'])->findOrFail($id);
    }

    public function createEvaluation(array $data)
    {
        $validationSucceeds = !$this->evaluationExists($data);
        if($validationSucceeds) return Evaluation::create($data);
    }

    public function updateEvaluation($id, array $data)
    {
        $evaluation = Evaluation::findOrFail($id);
        $evaluation->update($data);

        return $evaluation;
    }

    public function deleteEvaluation($id)
    {
        Evaluation::findOrFail($id)->delete();
    }

    //Duplication Validation
    protected function evaluationExists(array $data)
    {
        return Evaluation::where([
            'academic_id' => $data['academic_id'],
            'faculty_id' => $data['faculty_id'],
            'type' => $data['type'],
        ])->exists();
    }

}
