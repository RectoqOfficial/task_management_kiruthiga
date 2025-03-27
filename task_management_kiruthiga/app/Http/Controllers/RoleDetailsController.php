<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleDetail;

class RoleDetailsController extends Controller
{
    // Show Role Details Page
   public function index()
{
    $roles = RoleDetail::all();
    return view('admin.role_details', compact('roles'));
}


    // Store Role
    public function store(Request $request)
    {
        // Validate Input
        $request->validate([
            'role' => 'required|unique:role_details',
            'department' => 'required',
        ]);

        // Insert into Database
        RoleDetail::create([
            'role' => $request->role,
            'department' => $request->department,
        ]);

        return response()->json(['message' => 'Role added successfully!']);
    }
    public function destroy($id)
{
    RoleDetail::findOrFail($id)->delete();
    return response()->json(['message' => 'Role deleted successfully!']);
}

}
