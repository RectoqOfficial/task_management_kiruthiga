<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleDetail;

class RoleDetailController extends Controller
{
    // Display the list of roles in the view
    public function index()
    {
        // Fetch all role details from the database
        $rolesDetails = RoleDetail::all();

        // Return the 'role_detail' view and pass the roles to it
        return view('tasks.role_detail', compact('rolesDetails'));
    }

    // Store a new role into the database
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'role' => 'required|unique:role_details,role|max:255',
            'department' => 'required|max:255'
        ]);

        // Create a new RoleDetail entry
        $role = RoleDetail::create([
            'role' => $request->role,
            'department' => $request->department
        ]);

        // Return a JSON response after successful creation
        return response()->json([
            'success' => true, 
            'role' => $role, // Return the created role
            'message' => 'Role added successfully!'
        ]);
    }

    // Delete a role from the database
    public function destroy($id)
    {
        // Find the role by its ID
        $role = RoleDetail::find($id);

        // Check if the role exists, then delete it
        if ($role) {
            $role->delete();
            return response()->json(['success' => true, 'message' => 'Role deleted successfully!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Role not found!']);
        }
    }
    public function employeeDetails()
{
    // Fetch role details from the database
    $roleDetails = RoleDetail::all(); // Use RoleDetail if that's your model

    // Passing the variable to the view
    return view('tasks.employee_details', compact('roleDetails'));
}
}
