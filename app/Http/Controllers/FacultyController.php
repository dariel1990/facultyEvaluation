<?php

namespace App\Http\Controllers;

use App\Models\Faculties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class FacultyController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:faculty-list', ['only' => ['index']]);
        $this->middleware('permission:faculty-create', ['only' => ['store']]);
        $this->middleware('permission:faculty-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:faculty-delete', ['only' => ['delete']]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name'            => 'required',
            'middle_name'           => 'required',
            'last_name'             => 'required',
            'contact_no'            => 'required',
            'employment_status'     => 'required',
        ]);

        $record = Faculties::create([
            'department_id'         => $request->department_id,
            'first_name'            => strtoupper($request->first_name),
            'middle_name'           => strtoupper(substr($request->middle_name, 0, 1)),
            'last_name'             => strtoupper($request->last_name),
            'suffix'                => strtoupper($request->suffix),
            'contact_no'            => $request->contact_no,
            'employment_status'     => $request->employment_status,
        ]);

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        return Faculties::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name'            => 'required',
            'middle_name'           => 'required',
            'last_name'             => 'required',
            'contact_no'            => 'required',
            'employment_status'     => 'required',
        ]);

        $records = Faculties::find($id);
        $records->department_id     = $request->department_id;
        $records->first_name        = strtoupper($request->first_name);
        $records->middle_name       = strtoupper(substr($request->middle_name, 0, 1));
        $records->last_name         = strtoupper($request->last_name);
        $records->suffix            = strtoupper($request->suffix);
        $records->contact_no        = $request->contact_no;
        $records->employment_status = $request->employment_status;
        $records->save();

        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        try{
            Faculties::find($id)->delete();
            return response()->json(['success' => true]);
        }catch(QueryException $e){
            return response()->json(['success' => $e]);
        }
    }

}
