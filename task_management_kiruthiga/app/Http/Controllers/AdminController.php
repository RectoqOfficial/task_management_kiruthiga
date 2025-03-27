<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth'); // Ensures only authenticated users can access
        $this->middleware('role:admin'); // Ensures only admins can access
    }
    public function index()
    {
       
        return view('admin.dashboard');
    }
     public function roleDetails()
    {
        return view('admin.role_details');
    }

    public function employeeDetails()
    {
        return view('admin.employee_details');
    }

    public function taskDetails()
    {
        return view('admin.task_details');
    }

    public function scoreboard()
    {
        return view('admin.scoreboard');
    }
}
