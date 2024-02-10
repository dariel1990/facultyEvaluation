<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:dashboard', ['only' => ['index']]);
        $this->middleware('permission:studentDashboard', ['only' => ['studentDashboard']]);
        $this->middleware('permission:peerDashboard', ['only' => ['peerDashboard']]);
        $this->middleware('permission:supervisorDashboard', ['only' => ['supervisorDashboard']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.home');
    }

    public function studentDashboard()
    {
        return view('users.studentDashboard');
    }

    public function peerDashboard()
    {
        return view('users.peerDashboard');
    }

    public function supervisorDashboard()
    {
        return view('users.supervisorDashboard');
    }

}
