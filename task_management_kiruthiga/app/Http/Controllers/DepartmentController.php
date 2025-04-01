<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('roles')->get();
        return view('admin.department', compact('departments'));
    }

   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255'
    ]);

    $department = Department::create([
        'name' => $request->name
    ]);

    return response()->json(['message' => 'Department added successfully!', 'department' => $department]);
}

    public function destroy($id) {
    Department::findOrFail($id)->delete();
    return response()->json(['message' => 'Deleted successfully']);
}
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255'
    ]);

    $department = Department::find($id);
    
    if (!$department) {
        return response()->json(['error' => 'Department not found.'], 404);
    }

    $department->name = $request->name;
    $department->save();

    return response()->json(['message' => 'Department updated successfully!', 'department' => $department]);
}


}
