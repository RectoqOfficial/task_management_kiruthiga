<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['department', 'role'])->get();
        $departments = Department::all();
        $roles = Role::all();

        return view('admin.employee', compact('employees', 'departments', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'gender' => 'required',
            'date_of_joining' => 'required|date',
            'contact' => 'required',
            'email_id' => 'required|email|unique:employees',
            'password' => 'required|min:6',
            'department_id' => 'required|exists:departments,id',
            'role_id' => 'required|exists:roles_id',
            'jobtype' => 'required',
        ]);

        Employee::create([
            'full_name' => $request->full_name,
            'gender' => $request->gender,
            'date_of_joining' => $request->date_of_joining,
            'contact' => $request->contact,
            'email_id' => $request->email_id,
            'password' => Hash::make($request->password), // Store password securely
            'department_id' => $request->department_id,
            'role_id' => $request->role_id,
            'jobtype' => $request->jobtype,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee added successfully!');
    }
public function getRolesByDepartment($department_id)
{
    $roles = Role::where('department_id', $department_id)->get();
    return response()->json($roles);
}


public function destroy($id)
{
    $employee = Employee::findOrFail($id);
    $employee->delete();

    return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
}

}
