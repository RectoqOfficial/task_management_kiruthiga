<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensures only authenticated users can access
        $this->middleware('role:employee'); // Ensures only employees can access
    }
    public function index()
    {
    
        return view('employee.dashboard');
    }
       public function myTasks()
    {
        return view('employee.tasks');
    }

    public function profile()
    {
        return view('employee.profile');
    }

    public function scoreboard()
    {
        return view('employee.scoreboard');
    }
}
