<?php

namespace App\Http\Controllers;

use App\Models\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class SubjectController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:subject-list', ['only' => ['index']]);
        $this->middleware('permission:subject-create', ['only' => ['store']]);
        $this->middleware('permission:subject-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:subject-delete', ['only' => ['delete']]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'class_id'      => 'required',
            'faculty_id'    => 'required',
            'subject_code'  => 'required',
            'description'   => 'required',
        ], [
            'faculty_id.required' => 'Please assign a faculty'
        ]);

        $record = Subjects::create([
            'class_id'      => $request->class_id,
            'faculty_id'    => $request->faculty_id,
            'subject_code'  => $request->subject_code,
            'description'   => $request->description,
        ]);

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        return Subjects::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'class_id'          => 'required',
            'faculty_id'        => 'required',
            'subject_code'      => 'required',
            'description'       => 'required',
        ]);

        $records = Subjects::find($id);
        $records->class_id       = $request->class_id;
        $records->faculty_id     = $request->faculty_id;
        $records->subject_code   = $request->subject_code;
        $records->description    = $request->description;
        $records->save();

        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        try{
            Subjects::find($id)->delete();
            return response()->json(['success' => true]);
        }catch(QueryException $e){
            return response()->json(['success' => $e]);
        }
    }
}
