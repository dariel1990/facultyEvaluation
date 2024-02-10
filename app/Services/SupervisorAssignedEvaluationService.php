<?php

namespace App\Services;

use App\Models\SupervisorAssignedEvaluation;

class SupervisorAssignedEvaluationService
{
    public function getAllSupervisorAssignedEvaluation()
    {
        return SupervisorAssignedEvaluation::all();
    }

    public function getSupervisorAssignedEvaluationById($id)
    {
        return SupervisorAssignedEvaluation::findOrFail($id);
    }

    public function getAllCompletedEvaluator($evaluationId){
        return SupervisorAssignedEvaluation::where('hasCompleted', true)->where('evaluation_id', $evaluationId)->get();
    }

    public function getCommentsByEvaluationId($evaluationId)
    {
        return SupervisorAssignedEvaluation::with('evaluation', 'supervisor')->where('evaluation_id', $evaluationId)->get(['comment']);
    }

    public function getSupervisorAssignedEvaluationBySupervisorId($supervisorId, $defaultPeriod)
    {
        return SupervisorAssignedEvaluation::whereHas('evaluation', function($query) use ($defaultPeriod){
            $query->where('academic_id',$defaultPeriod);
        })
        ->with(['evaluation',
                'evaluation.faculty',
                'evaluation.faculty.department'])
        ->where('supervisor_id', $supervisorId)
        ->get();
    }

    public function createSupervisorAssignedEvaluation(array $data)
    {
        $validationSucceeds = !$this->supervisorAssignedEvaluationExists($data);
        if($validationSucceeds) return SupervisorAssignedEvaluation::create($data);
    }

    public function updateSupervisorAssignedEvaluation($id, array $data)
    {
        $record = SupervisorAssignedEvaluation::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function deleteSupervisorAssignedEvaluation($id)
    {
        SupervisorAssignedEvaluation::findOrFail($id)->delete();
    }

    protected function supervisorAssignedEvaluationExists(array $data)
    {
        return SupervisorAssignedEvaluation::where([
            'supervisor_id' => $data['supervisor_id'],
            'evaluation_id' => $data['evaluation_id'],
        ])->exists();
    }

}
