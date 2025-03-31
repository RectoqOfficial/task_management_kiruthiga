<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Department;
use App\Models\Role;
use App\Models\Employee;

class TaskController extends Controller
{
   public function index()
{
    $tasks = Task::with('employee')->get();
    $departments = Department::all();
    $roles = Role::all();
    $employees = Employee::all();

    return view('admin.task', compact('tasks', 'departments', 'roles', 'employees'));
}


    public function store(Request $request)
    {
        $request->validate([
            'task_title' => 'required|string|max:255',
            'description' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'role_id' => 'required|exists:roles,id',
            'assigned_to' => 'required|exists:employees,id',
            'task_start_date' => 'required|date',
            'no_of_days' => 'required|integer|min:1',
        ]);

        $deadline = date('Y-m-d', strtotime($request->task_start_date . ' + ' . $request->no_of_days . ' days'));

        Task::create([
            'task_title' => $request->task_title,
            'description' => $request->description,
            'department_id' => $request->department_id,
            'role_id' => $request->role_id,
            'assigned_to' => $request->assigned_to,
            'task_create_date' => now()->format('Y-m-d'),
            'task_start_date' => $request->task_start_date,
            'no_of_days' => $request->no_of_days,
            'deadline' => $deadline,
            'status' => 'Pending',
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

   public function update(Request $request, $id)
{
    $task = Task::findOrFail($id);
    $task->status = $request->status;
    $task->save();

    if ($request->ajax()) {
        return response()->json(['success' => true, 'status' => $task->status]);
    }

    return redirect()->back();
}

    public function getRolesByDepartment(Request $request)
    {
        $roles = Role::where('department_id', $request->department_id)->get();
        return response()->json($roles);
    }

   public function getEmployeesByRole(Request $request)
{
    $roleId = $request->role_id;
    $employees = User::where('role_id', $roleId)
                     ->select('id', 'email') // Fetch email and id
                     ->get();

    return response()->json($employees);
}

}
