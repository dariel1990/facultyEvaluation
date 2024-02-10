<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Questions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class CriteriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:criteria-list', ['only' => ['index']]);
        $this->middleware('permission:criteria-create', ['only' => ['store']]);
        $this->middleware('permission:criteria-edit', ['only' => ['edit', 'update', 'updateOrder']]);
        $this->middleware('permission:criteria-delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        $criterias = Criteria::orderBy('order_by', 'ASC')->get();
        $questions = Questions::get();

        return view('admin.criteria-questions.index',compact('criterias', 'questions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'criteria' => 'required',
            'percentage' => 'required|numeric',
        ]);

        $maxOrderBy = Criteria::max('order_by');

        Criteria::create([
            'criteria' => $request->input('criteria'),
            'order_by' => $maxOrderBy + 1,
            'percentage' => $request->input('percentage'),
        ]);

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        return Criteria::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'criteria' => 'required',
            'percentage' => 'required|numeric',
        ]);

        $records = Criteria::find($id);
        $records->criteria      = $request->criteria;
        $records->percentage    = $request->percentage;
        $records->save();

        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        try{
            DB::table("criterias")->where('id', $id)->delete();
            return response()->json(['success' => true]);
        }catch(QueryException $e){
            return response()->json(['success' => false]);
        }
    }

    public function updateOrder(Request $request, $id)
    {
        $criteria = Criteria::findOrFail($id);
        $criteria->order_by = $request->input('order_by');
        $criteria->save();

        return response()->json(['message' => 'Order updated successfully']);
    }
}
