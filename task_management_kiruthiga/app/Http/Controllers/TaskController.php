<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Department;
use App\Models\Role;
use App\Models\Employee;
use App\Models\User;
use App\Models\Score; 
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Display the list of tasks, departments, roles, and employees
    public function index()
    {
        $tasks = Task::with('employee')->get();
        $departments = Department::all();
        $roles = Role::all();
        $employees = Employee::all();

        return view('admin.task', compact('tasks', 'departments', 'roles', 'employees'));
    }

    // Store a new task (Admin creates a task without task_start_date)
// Store a new task (Admin creates a task without task_start_date)
public function store(Request $request)
{
    \Log::info('Task creation request:', $request->all());

    $request->validate([
        'task_title' => 'required|string|max:255',
        'description' => 'required|string',
        'department_id' => 'required|exists:departments,id',
        'role_id' => 'required|exists:roles,id',
        'assigned_to' => 'required|exists:employees,id',
        'task_start_date' => 'nullable|date',
        'no_of_days' => 'required|integer|min:1',
    ]);

    // Use the provided start date, or default to today
    $taskStartDate = $request->task_start_date ? new \DateTime($request->task_start_date) : new \DateTime();
    $noOfDays = $request->no_of_days;

    try {
        $taskStartDate->modify("+$noOfDays days"); // Add days
        $taskStartDate->modify("-1 day"); // Subtract 1 day

        $deadline = $taskStartDate->format('Y-m-d');
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error calculating the deadline'], 400);
    }

    try {
        $task = Task::create([
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

        Score::create([
            'task_id' => $task->id,
            'redo_count' => 0,
            'overdue_count' => 0,
            'score' => 100,
        ]);

  $employee = Employee::find($request->assigned_to);

return response()->json([
    'success' => true,
    'message' => 'Task created successfully',
    'task' => $task,
    'employee' => $employee,
        'score' => [
        'redo_count' => 0,
        'overdue_count' => 0,
        'score' => 100
    ]
], 201);

    } catch (\Exception $e) {
        \Log::error('Error creating task: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Error creating task'], 500);
    }
}





    // Employee updates task_start_date when they start working
    public function updateTaskStartDate(Request $request, $id)
    {
        $request->validate([
            'task_start_date' => 'required|date',
        ]);

        try {
            $task = Task::findOrFail($id);
            $task->task_start_date = $request->task_start_date;
            $task->deadline = date('Y-m-d', strtotime($request->task_start_date . ' + ' . $task->no_of_days . ' days'));
            $task->save();

            return response()->json(['success' => true, 'message' => 'Task start date updated successfully!']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating start date'], 500);
        }
    }

    // Update Task Status
    public function updateStatus(Request $request, $id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->status = $request->status;
            $task->save();

            return response()->json(['success' => true, 'status' => $task->status]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating status'], 500);
        }
    }


      // Delete a task
 public function destroy($id)
{
    $task = Task::findOrFail($id);
    $task->delete();

    return response()->json(['success' => true]);
}


    // Get roles by department
    public function getRolesByDepartment(Request $request)
    {
        $roles = Role::where('department_id', $request->department_id)->get();
        return response()->json($roles);
    }

    // Get employees by role (Fixed: Now using Employee model)
    public function getEmployeesByRole(Request $request)
    {
        $roleId = $request->query('role_id');
        $employees = Employee::where('role_id', $roleId)->get(['id', 'full_name', 'email_id']);
        return response()->json($employees);
    }

   
 // Fetch all tasks assigned to the logged-in employee
public function myTasks()
{
    if (!Auth::guard('employee')->check()) {
        return redirect()->route('employee.login')->with('error', 'Please log in to view your tasks.');
    }

    $employee = Auth::guard('employee')->user();

    $tasks = Task::where('assigned_to', $employee->id)->get();

    return view('employee.tasks', compact('tasks'));
}



  // Fetch a specific task when the employee clicks on a task
public function viewTask($id)
{
    $employee = Auth::user();

    // Ensure the task is assigned to the logged-in employee
    $task = Task::where('id', $id)
        ->where('assigned_to', $employee->id)
        ->first();

    if (!$task) {
        return response()->json(['error' => 'Task not found or unauthorized access'], 404);
    }

    return response()->json([
        'task_title'   => $task->task_title,
        'description'  => $task->description,
        'deadline'     => $task->deadline,
    ]);
}

public function updateStartDate(Request $request, $id)
{
    $request->validate([
        'task_start_date' => 'required|date',
    ]);

    $task = Task::findOrFail($id);

    if (!$task) {
        return response()->json(['message' => 'Task not found'], 404);
    }

    // Update start date
    $task->task_start_date = $request->task_start_date;

    // Ensure no_of_days exists before calculating deadline
    if (!empty($task->no_of_days)) {
        $task->deadline = date('Y-m-d', strtotime($request->task_start_date . " + {$task->no_of_days} days"));
    }

    $task->save();

    return response()->json([
        'success' => true,
        'message' => 'Task start date updated successfully',
        'task' => $task
    ]);
}
public function updateDeadline(Request $request, $id)
{
    $task = Task::find($id);
    if (!$task) {
        return response()->json(['success' => false, 'message' => 'Task not found']);
    }

    $task->deadline = $request->deadline;
    $task->save();

    return response()->json(['success' => true, 'message' => 'Deadline updated successfully']);
}
public function updateRemarks(Request $request, $id)
{
    $task = Task::findOrFail($id);

    $request->validate([
        'remarks' => 'required|string|max:500'
    ]);

    $task->remarks = $request->remarks;
    $task->save();

    return response()->json(['success' => true, 'message' => 'Remark updated successfully', 'remarks' => $task->remarks]);
}

//redo count
public function redoTask(Request $request)
{
    $task = Task::find($request->task_id);
if ($task && $task->score) {
    $task->redo_count += 1;
    $task->score->score -= 10;
    $task->score->save();

    $task->status = "Pending";
    $task->save();

    return response()->json([
        'redo_count' => $task->redo_count,
        'status' => $task->status,
        'score' => $task->score->score
    ]);
}


    return response()->json(['error' => 'Task not found!'], 404);
}






public function showScoreboard()
{
    $tasks = Task::with('score')->get(); // Ensure the relationship is loaded
    return view('scoreboard', compact('tasks'));
}


}
