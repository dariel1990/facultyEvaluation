<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Classes;
use App\Models\Faculties;
use App\Models\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class ClassesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:class-list', ['only' => ['index']]);
        $this->middleware('permission:class-create', ['only' => ['store']]);
        $this->middleware('permission:class-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:class-delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        $defaultAcademicYear = AcademicYear::where('isDefault', true)->first();
        $classes = Classes::where('academic_id', $defaultAcademicYear->id)->get();
        $subjects = Subjects::with('faculty')->get();
        $faculties = Faculties::get();
        return view('admin.classes-subjects.index',compact('classes', 'subjects', 'faculties', 'defaultAcademicYear'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'class_code'    => 'required|unique:classes,class_code',
            'course'        => 'required',
            'year_level'    => 'required',
            'section'       => 'required',
        ]);

        $record = Classes::create([
            'academic_id'   => $request->academic_id,
            'class_code'    => $request->class_code,
            'course'        => $request->course,
            'year_level'    => $request->year_level,
            'section'       => $request->section,
        ]);

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        return Classes::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'class_code'    => 'required|unique:classes,class_code,'. $id,
            'course'        => 'required',
            'year_level'    => 'required',
            'section'       => 'required',
        ]);

        $records = Classes::find($id);
        $records->class_code = $request->class_code;
        $records->course     = $request->course;
        $records->year_level = $request->year_level;
        $records->section    = $request->section;
        $records->save();

        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        try{
            DB::table("classes")->where('id', $id)->delete();
            return response()->json(['success' => true]);
        }catch(QueryException $e){
            return response()->json(['success' => false]);
        }
    }
}
