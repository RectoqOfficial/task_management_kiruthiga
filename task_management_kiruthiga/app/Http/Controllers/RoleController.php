<?php
namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Department;
use Illuminate\Http\Request;


class RoleController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'department_id' => 'required|exists:departments,id',
        'name' => 'required|string|max:255'
    ]);

    $role = Role::create([
        'department_id' => $request->department_id,
        'name' => $request->name,
    ]);

    // Return JSON response
    return response()->json([
        'message' => 'Role added successfully!',
        'role' => $role
    ]);
}


    // ✅ FIXED: Correctly deletes a Role instead of a Department
   public function destroy($id)
{
    $role = Role::findOrFail($id);
    $role->delete();

    return response()->json([
        'message' => 'Role deleted successfully!',
        'role_id' => $id
    ]);
}


public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255'
    ]);

    $role = Role::find($id);
    
    if (!$role) {
        return response()->json(['error' => 'Role not found.'], 404);
    }

    $role->name = $request->name;
    $role->save();

    return response()->json(['message' => 'Role updated successfully!', 'role' => $role]);
}


}
