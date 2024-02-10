<?php

namespace App\Http\Controllers;

use App\Models\Students;
use App\Models\Subjects;
use Illuminate\Http\Request;
use App\Models\SubjectStudents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class StudentController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:student-list', ['only' => ['index']]);
        $this->middleware('permission:student-create', ['only' => ['store']]);
        $this->middleware('permission:student-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:student-delete', ['only' => ['delete']]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name'    => 'required',
            'middle_name'   => 'required',
            'last_name'     => 'required',
            'course'        => 'required',
            'year_level'    => 'required',
            'section'       => 'required',
        ]);

        $subjectId = $request->subject_id;

        $existingStudent = Students::where('last_name', $request->last_name)
            ->where('first_name', $request->first_name)
            ->where('middle_name', $request->middle_name)
            ->first();

        if ($existingStudent) {
            $existingSubjectStudent = SubjectStudents::where('subject_id', $subjectId)
                ->where('student_id', $existingStudent->id)
                ->exists();

            $studentSubjects = SubjectStudents::where('student_id', $existingStudent->id)->first();

            if (!$existingSubjectStudent) {
                $subjectCode = Subjects::find($subjectId);

                $hasDuplicatedSubjects = $existingStudent->subjects->pluck('subject_code')->contains($subjectCode->subject_code);
                if (!$hasDuplicatedSubjects) {
                    SubjectStudents::create([
                        'subject_id' => $subjectId,
                        'student_id' => $existingStudent->id,
                    ]);

                    return response()->json(['success' => true]);
                }else{
                    return response()->json(['error' => 'Student already enrolled in same Subject']);
                }
            }
            return response()->json(['success' => false, 'error' => 'Student already exists.']);
        }

        $record = Students::create([
            'first_name'    => strtoupper($request->first_name),
            'middle_name'   => strtoupper(substr($request->middle_name, 0, 1)),
            'last_name'     => strtoupper($request->last_name),
            'suffix'        => strtoupper($request->suffix),
            'course'        => $request->course,
            'year_level'    => $request->year_level,
            'section'       => $request->section,
        ]);

        SubjectStudents::create([
            'subject_id' => $subjectId,
            'student_id' => $record->id,
        ]);

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        return Students::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name'    => 'required',
            'middle_name'   => 'required',
            'last_name'     => 'required',
            'course'        => 'required',
            'year_level'    => 'required',
            'section'       => 'required',
        ]);

        $record = Students::find($id);

        $record->first_name     = strtoupper($request->first_name);
        $record->middle_name    = strtoupper(substr($request->middle_name, 0, 1));
        $record->last_name      = strtoupper($request->last_name);
        $record->suffix         = strtoupper($request->suffix);
        $record->course         = $request->course;
        $record->year_level     = $request->year_level;
        $record->section        = $request->section;
        $record->save();

        return response()->json(['success' => true]);
    }

    public function delete($id, $subjectId)
    {
        try{
            SubjectStudents::where('student_id', $id)->where('subject_id', $subjectId)->delete();
            return response()->json(['success' => true]);
        }catch(QueryException $e){
            return response()->json(['success' => false]);
        }
    }
}
