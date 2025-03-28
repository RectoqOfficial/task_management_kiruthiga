<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleDetail;

class RoleDetailController extends Controller
{
    public function index()
    {
        $roles = RoleDetail::all();
        return view('admin.role_details', compact('roles'));
    }

   public function store(Request $request)
{
    $request->validate([
        'role' => 'required|unique:role_details,role|max:255',
        'department' => 'required|max:255'
    ]);

    // Store the role in a variable before returning
    $role = RoleDetail::create([
        'role' => $request->role,
        'department' => $request->department
    ]);

    return response()->json([
        'success' => true, 
        'role' => $role, // Use the stored variable here
        'message' => 'Role added successfully!'
    ]);
}


    public function destroy($id)
    {
        $role = RoleDetail::find($id);
        if ($role) {
            $role->delete();
            return response()->json(['success' => true, 'message' => 'Role deleted successfully!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Role not found!']);
        }
    }
}
