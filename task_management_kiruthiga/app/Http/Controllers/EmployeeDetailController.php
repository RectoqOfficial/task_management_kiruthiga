<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDetail;
use App\Models\RoleDetail; // Use RoleDetail model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class EmployeeDetailController extends Controller
{
    // Show the employee details form and the employee list
    public function index()
    {
        // Get all employees and role details to pass to the view
        $employees = EmployeeDetail::all();
        $roleDetails = RoleDetail::all(); // Fetch roles and departments from RoleDetail model

        return view('tasks.employee_details', compact('employees', 'roleDetails'));
    }

 
public function store(Request $request)
{
    $validatedData = $request->validate([
        'fullname' => 'required|string|max:255',
        'gender' => 'required|string',
        'date_of_joining' => 'required|date',
        'contact' => 'required|string|max:15',
        'email_id' => 'required|email|unique:employees,email',
        'password' => 'required|string|min:8',
        'department' => 'required|string|max:255',
        'designation' => 'required|string|max:255',
        'jobtype' => 'required|string',
        'role_id' => 'required|exists:roles,id',
    ]);

    // Hash the password before saving
    $employeeDetail = EmployeeDetail::create([
        'fullname' => $validatedData['fullname'],
        'gender' => $validatedData['gender'],
        'date_of_joining' => $validatedData['date_of_joining'],
        'contact' => $validatedData['contact'],
        'email_id' => $validatedData['email_id'],
        'password' => Hash::make($validatedData['password']),  // Hashing the password
      
        'department' => $validatedData['department'],
        'designation' => $validatedData['designation'],
        'jobtype' => $validatedData['jobtype'],
          'role_id' => $validatedData['role_id'],
    ]);
 // Store the new employee
        EmployeeDetail::create($validatedData);
    return redirect()->route('employee_details.index')->with('success', 'Employee added successfully!');
}

  public function destroy($id)
{
    $employee = EmployeeDetail::find($id);

    if ($employee) {
        $employee->delete();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 404);
}
public function employeeDetails()
{
    // You need to fetch role details from the database
    $roleDetails = Role::all(); // or any method to get the relevant data

    // Passing the variable to the view
    return view('tasks.employee_details', compact('roleDetails'));
}


}
