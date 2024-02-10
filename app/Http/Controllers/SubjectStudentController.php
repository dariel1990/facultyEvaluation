<?php

namespace App\Http\Controllers;

use App\Imports\StudentImport;
use App\Models\Subjects;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SubjectStudentController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:subject-student-list', ['only' => ['index']]);
        $this->middleware('permission:subject-student-import', ['only' => ['importStudents']]);
    }

    public function index($subjectId)
    {
        $subject = Subjects::find($subjectId);
        $students = $subject->students()->orderBy('last_name', 'ASC')->get();

        return view('admin.subject-students.index',compact('students', 'subject'));
    }

    public function importStudents(Request $request){

        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        $file = $request->file('file');
        $subjectId = $request->input('subject_id');
        $course = $request->input('course');
        $yearLevel = $request->input('year_level');
        $section = $request->input('section');

        // Use the AccountsImport class to import data from the Excel file
        Excel::import(new StudentImport($subjectId, $course, $yearLevel, $section), $file);

        return redirect()->back()->with('success', 'Data imported successfully.');
    }

}
