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
            'name' => 'required'
        ]);

  Role::create([
            'department_id' => $request->department_id,
            'name' => $request->name,
        ]);

        return back()->with('success', 'Role added successfully.');
    }
    public function destroy($id) {
    Department::findOrFail($id)->delete();
    return response()->json(['message' => 'Deleted successfully']);
}
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $role = Role::findOrFail($id);
    $role->name = $request->name;
    $role->save();

    return redirect()->back()->with('success', 'Role updated successfully!');
}

}
