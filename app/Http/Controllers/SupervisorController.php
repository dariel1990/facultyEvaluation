<?php

namespace App\Http\Controllers;

use App\Services\SupervisorService;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    protected $supervisorService;

    public function __construct(SupervisorService $supervisorService)
    {
        $this->supervisorService    = $supervisorService;

        $this->middleware('permission:supervisor-list', ['only' => ['index']]);
        $this->middleware('permission:supervisor-create', ['only' => ['store']]);
        $this->middleware('permission:supervisor-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:supervisor-delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        $supervisors = $this->supervisorService->getAllSupervisors();

        return view('admin.supervisor.index',compact('supervisors'));
    }

    public function store(Request $request){
        $supervisor = [
            "first_name"    => strtoupper($request->first_name),
            "middle_name"   => strtoupper(substr($request->middle_name, 0, 1)),
            "last_name"     => strtoupper($request->last_name),
            "suffix"        => strtoupper($request->suffix),
            "contact_no"    => $request->contact_no,
        ];

        $this->supervisorService->createSupervisor($supervisor);

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $supervisor = $this->supervisorService->getSupervisorById($id);

        return $supervisor;
    }

    public function update(Request $request, $id)
    {
        $supervisor = [
            "first_name"    => strtoupper($request->first_name),
            "middle_name"   => strtoupper(substr($request->middle_name, 0, 1)),
            "last_name"     => strtoupper($request->last_name),
            "suffix"        => strtoupper($request->suffix),
            "contact_no"    => $request->contact_no,
        ];

        $this->supervisorService->updateSupervisor($id, $supervisor);

        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        $this->supervisorService->deleteSupervisor($id);

        return response()->json(['success' => true]);
    }
}
