<?php

namespace App\Services;

use App\Models\PeerAssignedEvaluation;

class PeerAssignedEvaluationService
{
    public function getAllPeerAssignedEvaluation()
    {
        return PeerAssignedEvaluation::all();
    }

    public function getPeerAssignedEvaluationById($id)
    {
        return PeerAssignedEvaluation::findOrFail($id);
    }

    public function getAllCompletedEvaluator($evaluationId){
        return PeerAssignedEvaluation::where('hasCompleted', true)->where('evaluation_id', $evaluationId)->get();
    }

    public function getCommentsByEvaluationId($evaluationId)
    {
        return PeerAssignedEvaluation::with('evaluation', 'faculty')->where('evaluation_id', $evaluationId)->get(['comment']);
    }

    public function getPeerAssignedEvaluationByPeerId($peerId, $defaultPeriod)
    {
        return PeerAssignedEvaluation::whereHas('evaluation', function($query) use ($defaultPeriod){
            $query->where('academic_id',$defaultPeriod);
        })
        ->with(['evaluation',
                'evaluation.faculty',
                'evaluation.faculty.department'])
        ->where('faculty_id', $peerId)
        ->get();
    }

    public function createPeerAssignedEvaluation(array $data)
    {
        $validationSucceeds = !$this->peerAssignedEvaluationExists($data);
        if($validationSucceeds) return PeerAssignedEvaluation::create($data);
    }

    public function updatePeerAssignedEvaluation($id, array $data)
    {
        $record = PeerAssignedEvaluation::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function deletePeerAssignedEvaluation($id)
    {
        PeerAssignedEvaluation::findOrFail($id)->delete();
    }

    protected function peerAssignedEvaluationExists(array $data)
    {
        return PeerAssignedEvaluation::where([
            'faculty_id' => $data['faculty_id'],
            'evaluation_id' => $data['evaluation_id'],
        ])->exists();
    }

}
