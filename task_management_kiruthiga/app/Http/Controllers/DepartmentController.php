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
        $request->validate(['name' => 'required|unique:departments']);
        Department::create(['name' => $request->name]);
        return back()->with('success', 'Department created successfully.');
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

    $department = Department::findOrFail($id);
    $department->name = $request->name;
    $department->save();

    return redirect()->back()->with('success', 'Department updated successfully!');
}

}
