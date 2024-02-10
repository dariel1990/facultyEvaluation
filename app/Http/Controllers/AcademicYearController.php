<?php

namespace App\Http\Controllers;

use App\Models\Faculties;
use App\Models\Evaluation;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\EvaluationService;
use App\Rules\DuplicatedAcademicYear;
use App\Services\AcademicYearService;
use Illuminate\Database\QueryException;

class AcademicYearController extends Controller
{
    protected $evaluationService;
    protected $academicYearService;

    public function __construct(EvaluationService $evaluationService, AcademicYearService $academicYearService)
    {
        $this->evaluationService    = $evaluationService;
        $this->academicYearService  = $academicYearService;

        $this->middleware('permission:period-list', ['only' => ['index']]);
        $this->middleware('permission:period-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:period-edit', ['only' => ['edit', 'update', 'updateEvaluationStatus', 'updateDefaultStatus']]);
        $this->middleware('permission:period-delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        $data = AcademicYear::get();
        return view('admin.academic-year.index',compact('data'));
    }

    public function create()
    {
        return view('admin.academic-year.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'academic_year'     => ['required', new DuplicatedAcademicYear($request->semester)],
            'semester'          => 'required',
        ]);

        $record = AcademicYear::create([
            'academic_year'     => $request->academic_year,
            'semester'          => $request->semester,
        ]);

        return redirect()->route('academic.year')
                        ->with('success','Record added successfully');
    }

    public function edit($id)
    {
        $acad = AcademicYear::find($id);

        return view('admin.academic-year.edit',compact('acad'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'academic_year' => [
                                'required',
                                'unique:academic_years,academic_year,'. $id],
            'semester'      => 'required',
        ]);
        //update
        $records = AcademicYear::find($id);
        $records->academic_year = $request->academic_year;
        $records->semester = $request->semester;
        $records->save();

        return redirect()->route('academic.year')
                    ->with('success','Record updated successfully');
    }

    public function delete($id)
    {
        try{
            DB::table("academic_years")->where('id', $id)->delete();
            return response()->json(['success' => true]);
        }catch(QueryException $e){
            return response()->json(['success' => false]);
        }
    }

    public function updateEvaluationStatus(Request $request, $id){
        $data = ['evaluation_status' => (string) $request->status];

        $validationSucceeds = $this->academicYearService->isDefault($id);
        if($validationSucceeds){
            try{
                $records = $this->academicYearService->updatePeriod($id, $data);
                $btnClass = '';
                $newStatus ='';
                if($records->evaluation_status == '0') $btnClass = 'btn-secondary';
                if($records->evaluation_status == '1') $btnClass = 'btn-success';
                if($records->evaluation_status == '2') $btnClass = 'btn-danger';

                if($records->evaluation_status == '0') $newStatus = 'Not Started';
                if($records->evaluation_status == '1') $newStatus = 'Started';
                if($records->evaluation_status == '2') $newStatus = 'Closed';

                if($request->status == '1'){
                    $defaultAY = $records->id;

                    $faculties = Faculties::get();
                    $evaluationTypes = ['Student', 'Peer', 'Supervisor'];

                    foreach($faculties as $faculty){
                        foreach ($evaluationTypes as $type) {
                            $evaluationData = [
                                'academic_id' => $defaultAY,
                                'faculty_id' => $faculty->id,
                                'type' => $type
                            ];

                            $this->evaluationService->createEvaluation($evaluationData);
                        }
                    }
                }

                return response()->json(['success' => true, 'newStatus' => $newStatus, 'btnClass' => $btnClass ]);
            }catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while processing your request.'], 500);
            }
        }



    }

    public function updateDefaultStatus(Request $request, $id)
    {
        $currentDefaultRow = AcademicYear::where('isDefault', true)->first();

        if ($currentDefaultRow) {
            $currentDefaultRow->update(['isDefault' => false]);
        }

        $newDefaultRow = AcademicYear::findOrFail($id);

        $newDefaultRow->update(['isDefault' => true]);

        return redirect()->back()->with('success', 'Default status updated successfully.');
    }
}
