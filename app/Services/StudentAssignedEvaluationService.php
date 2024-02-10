<?php

namespace App\Services;

use App\Models\Evaluation;
use App\Models\AcademicYear;
use App\Models\StudentAssignedEvaluation;
use Illuminate\Support\Facades\Validator;

class StudentAssignedEvaluationService
{
    public function getAllStudentAssignedEvaluation()
    {
        return StudentAssignedEvaluation::all();
    }

    public function getStudentAssignedEvaluationById($id)
    {
        return StudentAssignedEvaluation::with('evaluation', 'student')->findOrFail($id);
    }

    public function getAllCompletedEvaluator($evaluationId){
        return StudentAssignedEvaluation::where('hasCompleted', true)->where('evaluation_id', $evaluationId)->get();
    }

    public function getCommentsByEvaluationId($evaluationId)
    {
        return StudentAssignedEvaluation::with('evaluation', 'student')->where('evaluation_id', $evaluationId)->get(['comment']);
    }

    public function getStudentAssignedEvaluationByStudentId($userId, $defaultPeriod)
    {
        return StudentAssignedEvaluation::whereHas('evaluation', function($query) use ($defaultPeriod){
                                            $query->where('academic_id',$defaultPeriod);
                                        })
                                        ->with(['evaluation',
                                                'evaluation.faculty',
                                                'evaluation.faculty.department'])
                                        ->where('student_id', $userId)
                                        ->get();
    }


    public function createStudentAssignedEvaluation(array $data)
    {
        $validationSucceeds = !$this->StudentAssignedEvaluationExists($data);
        if($validationSucceeds) return StudentAssignedEvaluation::create($data);
    }

    public function updateStudentAssignedEvaluation($id, array $data)
    {
        $record = StudentAssignedEvaluation::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function deleteStudentAssignedEvaluation($id)
    {
        StudentAssignedEvaluation::findOrFail($id)->delete();
    }

    protected function StudentAssignedEvaluationExists(array $data)
    {
        return StudentAssignedEvaluation::where([
            'student_id' => $data['student_id'],
            'evaluation_id' => $data['evaluation_id'],
        ])->exists();
    }

}
