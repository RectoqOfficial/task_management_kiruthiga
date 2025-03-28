<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeDetail;
use App\Models\RoleDetail;
use Illuminate\Support\Facades\Hash;

class EmployeeDetailController extends Controller
{
    // Show Employee List Page
    public function index()
    {
        $employees = EmployeeDetail::with('role')->paginate(10);
        return view('employees.index', compact('employees'));
    }

    // Show Create Employee Form
    public function create()
    {
       $roleDetails = RoleDetail::all();
        return view('employees.create', compact('roleDetails'));
    }

    // Store Employee Data
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'gender' => 'required|string',
            'date_of_joining' => 'required|date',
            'contact' => 'required|regex:/^[0-9]{10,15}$/',
            'email_id' => 'required|email|unique:employee_details,email_id',
            'password' => 'required|string|min:6',
            'department' => 'required|string',
            'designation' => 'required|string',
            'job_type' => 'required|string',
            'role_id' => 'required|exists:role_details,id',
        ]);

        EmployeeDetail::create([
            'fullname' => $request->fullname,
            'gender' => $request->gender,
            'date_of_joining' => $request->date_of_joining,
            'contact' => $request->contact,
            'email_id' => $request->email_id,
            'password' => bcrypt($request->password),
            'department' => $request->department,
            'designation' => $request->designation,
            'job_type' => $request->job_type,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee added successfully');
    }
}
