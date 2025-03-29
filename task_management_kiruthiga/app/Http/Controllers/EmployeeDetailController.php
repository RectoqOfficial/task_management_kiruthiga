<?php

namespace App\Http\Controllers;
use App\Models\RoleDetail;


use App\Models\EmployeeDetail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class EmployeeDetailController extends Controller
{
    // Display the Employee Details page
    public function index()
    {
        $employees = EmployeeDetail::with('role')->get();
        $roleDetails = RoleDetail::all();
        return view('tasks.employee_details', compact('employees', 'roleDetails'));
    }

    // Store a new Employee
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'date_of_joining' => 'required|date',
            'contact' => 'required|string|max:20',
            'email' => 'required|email|unique:employee_details,email',
            'password' => 'required|min:6',
            'department' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'jobtype' => ['required', Rule::in(['onsite', 'remote'])],
            'role_id' => 'required|exists:role_details,id',

        ]);

        $validatedData['password'] = Hash::make($request->password);

          // Store the new employee and save it in a variable
    $employee = EmployeeDetail::create($validatedData);
  // Fetch role details dynamically
    $employee->role = $employee->role()->first(); 


       // Return JSON response instead of redirect
   return response()->json([
        'message' => 'Employee added successfully!',
        'employee' => $employee
    ]);
    }

    // Delete an Employee
    public function destroy($id)
    {
        $employee = EmployeeDetail::findOrFail($id);
        $employee->delete();

        return response()->json(['success' => true]);
    }
}
