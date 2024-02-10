<?php

namespace App\Services;

use App\Models\AcademicYear;
use App\Models\Answers;
use Illuminate\Support\Facades\Validator;

class AnswerService
{
    public function getAllAnswerByUserAndByEvaluation($userId, $evaluationId)
    {
        return Answers::where('user_id', $userId)->where('evaluation_id', $evaluationId)->get();
    }

    public function getAllAnswerByEvaluation($evaluationId)
    {
        return Answers::with(['question', 'question.criteria'])->where('evaluation_id', $evaluationId)->get();
    }

    public function getAnswersById($id)
    {
        return Answers::findOrFail($id);
    }

    public function createAnswers(array $data)
    {
        return Answers::create($data);
    }
}
