<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class QuestionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:question-list', ['only' => ['index']]);
        $this->middleware('permission:question-create', ['only' => ['store']]);
        $this->middleware('permission:question-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:question-delete', ['only' => ['delete']]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'criteria_id'   => 'required',
            'question'      => 'required|unique:questions,question',

        ]);

        $record = Questions::create([
            'criteria_id'   => $request->criteria_id,
            'question'      => $request->question,
        ]);

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        return Questions::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'criteria_id'   => 'required',
            'question'      => 'required|unique:questions,question,'. $id,
        ]);

        $records = Questions::find($id);
        $records->criteria_id    = $request->criteria_id;
        $records->question       = $request->question;
        $records->save();

        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        try{
            Questions::find($id)->delete();
            return response()->json(['success' => true]);
        }catch(QueryException $e){
            return response()->json(['success' => $e]);
        }
    }
}
