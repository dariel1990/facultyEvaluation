<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Students;
use App\Models\Faculties;
use App\Models\Questions;
use App\Models\Evaluation;
use App\Models\Supervisor;
use App\Models\AcademicYear;
use App\Models\Answers;
use Illuminate\Http\Request;
use App\Services\AnswerService;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Services\EvaluationService;
use Illuminate\Support\Facades\Auth;
use App\Services\AcademicYearService;
use App\Models\StudentAssignedEvaluation;
use Illuminate\Support\Facades\Validator;
use App\Services\PeerAssignedEvaluationService;
use App\Services\StudentAssignedEvaluationService;
use App\Services\SupervisorAssignedEvaluationService;

class EvaluationController extends Controller
{
    protected $evaluationService;
    protected $academicYearService;
    protected $studentAssignedEvaluation;
    protected $peerAssignedEvaluation;
    protected $supervisorAssignedEvaluation;
    protected $answerService;

    public function __construct(EvaluationService $evaluationService,
                                AcademicYearService $academicYearService,
                                StudentAssignedEvaluationService $studentAssignedEvaluation,
                                PeerAssignedEvaluationService $peerAssignedEvaluation,
                                SupervisorAssignedEvaluationService $supervisorAssignedEvaluation,
                                AnswerService $answerService)
    {
        $this->evaluationService    = $evaluationService;
        $this->academicYearService  = $academicYearService;
        $this->studentAssignedEvaluation  = $studentAssignedEvaluation;
        $this->peerAssignedEvaluation  = $peerAssignedEvaluation;
        $this->supervisorAssignedEvaluation  = $supervisorAssignedEvaluation;
        $this->answerService  = $answerService;

        $this->middleware('permission:evaluation-list', ['only' => ['index', 'dataTableList']]);
        $this->middleware('permission:evaluation-user', ['only' => ['evaluatorsEvaluationPage']]);
        $this->middleware('permission:evaluation-create', ['only' => ['store', 'assignStudents', 'assignPeers', 'assignSupervisor']]);
        $this->middleware('permission:evaluation-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:evaluation-delete', ['only' => ['delete']]);
        $this->middleware('permission:evaluate-form', ['only' => ['evaluate']]);
        $this->middleware('permission:evaluate-answer', ['only' => ['submitEvaluation']]);
    }

    public function index(Request $request)
    {
        $defaultPeriod = $this->academicYearService->getDefaultPeriod();
        $evaluations = $this->evaluationService->getEvaluationsForDefaultPeriod($defaultPeriod->id);
        $faculties = Faculties::get();
        $supervisors = Supervisor::get();

        return view('admin.evaluation.index',compact('evaluations', 'defaultPeriod', 'faculties', 'supervisors'));
    }

    public function evaluatorsEvaluationPage()
    {
        $evaluation = '';
        $defaultPeriod = $this->academicYearService->getDefaultPeriod();
        if(Auth::user()->hasRole('Student')){
            $studentId = Auth::user()->student->id;
            $evaluations = $this->studentAssignedEvaluation->getStudentAssignedEvaluationByStudentId($studentId, $defaultPeriod->id);
        }else if(Auth::user()->hasRole('Peer')){
            $peerId = Auth::user()->faculty->id;
            $evaluations = $this->peerAssignedEvaluation->getPeerAssignedEvaluationByPeerId($peerId, $defaultPeriod->id);
        }else if(Auth::user()->hasRole('Supervisor')){
            $supervisorId = Auth::user()->supervisor->id;
            $evaluations = $this->supervisorAssignedEvaluation->getSupervisorAssignedEvaluationBySupervisorId($supervisorId, $defaultPeriod->id);
        }

        $faculties = Faculties::get();
        $supervisors = Supervisor::get();

        return view('admin.evaluation.evaluation',compact('evaluations', 'defaultPeriod', 'faculties', 'supervisors'));
    }

    public function dataTableList($type){

        $defaultPeriod = $this->academicYearService->getDefaultPeriod();

        if (request()->ajax()) {
            $data = $this->evaluationService->getEvaluationsByType($type, $defaultPeriod->id);

            return (new DataTables)->of($data)
            ->addColumn('FacultyFullname', function ($record) {
                return $record->faculty->fullname;
            })
            ->addColumn('Department', function ($record) {
                return $record->faculty->department->short_name;
            })
            ->addColumn('Status', function ($record) {
                return $record->faculty->employment_status;
            })
            ->addColumn('HasCompleted', function ($record) {
                $completed = 0;
                if($record->type == 'Student') { $completed = $record->studentAssigned->where('hasCompleted', true)->count(); }
                if($record->type == 'Peer') { $completed = $record->peerAssigned->where('hasCompleted', true)->count(); }
                if($record->type == 'Supervisor') { $completed = $record->supervisorAssigned->where('hasCompleted', true)->count(); }

                return $completed;
            })
            ->addColumn('Assigned', function ($record) {
                $assigned = 0;
                if($record->type == 'Student') { $assigned = $record->studentAssigned->count(); }
                if($record->type == 'Peer') { $assigned = $record->peerAssigned->count(); }
                if($record->type == 'Supervisor') { $assigned = $record->supervisorAssigned->count(); }

                return $assigned;
            })

            ->make(true);
        }
    }

    public function evaluate(Request $request, $assignmentId, $evaluationId)
    {
        $userType = '';
        $assignment = '';
        $user = Auth::user();
        $evaluation = $this->evaluationService->getEvaluationById($evaluationId);

        $criterias = Criteria::with('question')->get();

        if( $user->hasRole('Student')){
            $userType = 'Student';
            $assignment = $this->studentAssignedEvaluation->getStudentAssignedEvaluationById($assignmentId);
            if( $user->student->assignments->contains('evaluation_id', $evaluationId) &&
                !$user->student->assignments->where('evaluation_id', $evaluationId)->first()->hasCompleted &&
                !$assignment->hasCompleted){
            }else{
                return redirect()->route('evaluatorsEvaluationPage')->withErrors(['errorMessage' => 'Validation Fails']);
            }
        }else if($user->hasRole('Peer')){
            $userType = 'Peer';
            $assignment = $this->peerAssignedEvaluation->getPeerAssignedEvaluationById($assignmentId);
            if( $user->faculty->assignments->contains('evaluation_id', $evaluationId) &&
                !$user->faculty->assignments->where('evaluation_id', $evaluationId)->first()->hasCompleted &&
                !$assignment->hasCompleted){
            }else{
                return redirect()->route('evaluatorsEvaluationPage')->withErrors(['errorMessage' => 'Validation Fails']);
            }
        }else if($user->hasRole('Supervisor')){
            $userType = 'Supervisor';
            $assignment = $this->supervisorAssignedEvaluation->getSupervisorAssignedEvaluationById($assignmentId);
            if( $user->supervisor->assignments->contains('evaluation_id', $evaluationId) &&
                !$user->supervisor->assignments->where('evaluation_id', $evaluationId)->first()->hasCompleted &&
                !$assignment->hasCompleted){
            }else{
                return redirect()->route('evaluatorsEvaluationPage')->withErrors(['errorMessage' => 'Validation Fails']);
            }
        }

        return view('admin.evaluation.form', compact('criterias', 'evaluation', 'userType', 'evaluationId', 'assignmentId'));
    }

    public function submitEvaluation(Request $request, $evaluationId)
    {
        $user = Auth::user();
        $userId = $user->id;
        $questions = Questions::get();

        foreach ($questions as $question) {
            $rules['rate' . $question->id] = [
                'required',
                'integer',
                Rule::in(['1', '2', '3', '4', '5']),
            ];
        }

        $rules['comment'] = 'required|string';

        // Perform validation
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        foreach ($questions as $question) {
            $rate = $request->input('rate' . $question->id);
            $answers = [
                'user_id' => $userId, // Assuming you're using the authenticated user
                'evaluation_id' => $evaluationId,
                'question_id' => $question->id,
                'rate' => $rate,
            ];

            $this->answerService->createAnswers($answers);
        }

        $updateAssignmentData = [
            'hasCompleted' => true,
            'comment' => $request->comment,
        ];


        if($user->hasRole('Student') && $user->student->assignments->contains('evaluation_id', $evaluationId)){
            $this->studentAssignedEvaluation->updateStudentAssignedEvaluation($request->assignmentId, $updateAssignmentData);
        }else if($user->hasRole('Peer')){
            $this->peerAssignedEvaluation->updatePeerAssignedEvaluation($request->assignmentId, $updateAssignmentData);
        }else if($user->hasRole('Supervisor')){
            $this->supervisorAssignedEvaluation->updateSupervisorAssignedEvaluation($request->assignmentId, $updateAssignmentData);
        }else {
            abort(403, 'Unauthorized action.');
        }

        return redirect()->route('evaluatorsEvaluationPage')->with('success', 'Evaluation submitted successfully');
    }

    public function evaluationResult($assignmentId, $evaluationId)
    {
        // dd($assignmentId, $evaluationId);
        $userType = '';
        $user = Auth::user();
        $evaluation = $this->evaluationService->getEvaluationById($evaluationId);
        $assignment = '';
        $criterias = Criteria::with('question')->get();

        if( $user->hasRole('Student')){
            $userType = 'Student';
            $assignment = $this->studentAssignedEvaluation->getStudentAssignedEvaluationById($assignmentId);
            $answers = $this->answerService->getAllAnswerByUserAndByEvaluation($user->id, $evaluationId);
            if( $user->student->assignments->contains('evaluation_id', $evaluationId) &&
                $user->student->assignments->where('evaluation_id', $evaluationId)->first()->hasCompleted &&
                $assignment->hasCompleted){
            }else{
                return redirect()->route('evaluatorsEvaluationPage')->withErrors(['errorMessage' => 'Validation Fails']);
            }
        }else if($user->hasRole('Peer')){
            $userType = 'Peer';
            $assignment = $this->peerAssignedEvaluation->getPeerAssignedEvaluationById($assignmentId);
            $answers = $this->answerService->getAllAnswerByUserAndByEvaluation($user->id, $evaluationId);
            if($user->faculty->assignments->contains('evaluation_id', $evaluationId) &&
                $user->faculty->assignments->where('evaluation_id', $evaluationId)->first()->hasCompleted &&
                $assignment->hasCompleted){
            }else{
                return redirect()->route('evaluatorsEvaluationPage')->withErrors(['errorMessage' => 'Validation Fails']);
            }
        }else if($user->hasRole('Supervisor')){
            $userType = 'Supervisor';
            $assignment = $this->supervisorAssignedEvaluation->getSupervisorAssignedEvaluationById($assignmentId);
            $answers = $this->answerService->getAllAnswerByUserAndByEvaluation($user->id, $evaluationId);
            if( $user->supervisor->assignments->contains('evaluation_id', $evaluationId) &&
                $user->supervisor->assignments->where('evaluation_id', $evaluationId)->first()->hasCompleted &&
                $assignment->hasCompleted){
            }else{
                return redirect()->route('evaluatorsEvaluationPage')->withErrors(['errorMessage' => 'Validation Fails']);
            }
        }

        return view('admin.evaluation.evaluation-result', compact('criterias', 'evaluation', 'userType', 'evaluationId', 'assignment', 'answers'));
    }

    public function assignStudents(Request $request){
        $facultyId = $request->faculty_id;
        $evaluationId = $request->evaluation_id;
        $students = Students::whereHas('subjects', function ($query) use ($facultyId) {
            $query->where('faculty_id', $facultyId);
        })->get();

        if($students->count() > 0){
            foreach($students as $record){
                $studentAssignment = [
                    'student_id' => $record->id,
                    'evaluation_id' => $evaluationId,
                ];

                $this->studentAssignedEvaluation->createStudentAssignedEvaluation($studentAssignment);
            }

            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }

    public function assignPeers(Request $request){
        $facultyId = $request->faculty_id;
        $evaluationId = $request->evaluation_id;

        foreach($facultyId as $index => $faculties) {
            $peerAssignment = [
                'faculty_id' => $faculties,
                'evaluation_id' => $evaluationId,
            ];

            $this->peerAssignedEvaluation->createPeerAssignedEvaluation($peerAssignment);
        }
        return response()->json(['success' => true]);
    }

    public function assignSupervisor(Request $request){
        $supervisorId = $request->supervisor_id;
        $evaluationId = $request->sup_evaluation_id;

        foreach($supervisorId as $index => $supervisor) {
            $supervisorAssignment = [
                'supervisor_id' => $supervisor,
                'evaluation_id' => $evaluationId,
            ];

            $this->supervisorAssignedEvaluation->createSupervisorAssignedEvaluation($supervisorAssignment);
        }
        return response()->json(['success' => true]);
    }
}
