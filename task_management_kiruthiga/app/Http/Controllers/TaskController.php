<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Department;
use App\Models\Role;
use App\Models\Employee;
use App\Models\User;
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
public function store(Request $request)
{
    \Log::info('Task creation request:', $request->all());

    // Validate the incoming request data
    $request->validate([
        'task_title' => 'required|string|max:255',
        'description' => 'required|string',
        'department_id' => 'required|exists:departments,id',
        'role_id' => 'required|exists:roles,id',
        'assigned_to' => 'required|exists:employees,id',
        'task_start_date' => 'nullable|date',
        'no_of_days' => 'required|integer|min:1',
    ]);

    // If task start date is provided, use it to calculate the deadline
$taskStartDate = $request->task_start_date ? new \DateTime($request->task_start_date) : new \DateTime();
    $noOfDays = $request->no_of_days;

    // Check if both task_start_date and no_of_days are valid
    if (!$taskStartDate && $noOfDays) {
        return response()->json(['success' => false, 'message' => 'Task start date is required when no_of_days is provided.'], 400);
    }
// Check if no_of_days is provided
if (!$noOfDays) {
    return response()->json(['success' => false, 'message' => 'Number of days is missing or invalid.'], 400);
}


    // Calculate the deadline based on task start date and number of days
 // Calculate the deadline
try {
    $taskStartDate->modify("+$noOfDays days");
    $deadline = $taskStartDate->format('Y-m-d');
} catch (\Exception $e) {
    return response()->json(['success' => false, 'message' => 'Error calculating the deadline: ' . $e->getMessage()], 400);
}

    // Ensure that deadline is calculated or provided
    if ($deadline === null) {
        return response()->json(['success' => false, 'message' => 'Deadline could not be calculated.'], 400);
    }

    // Try creating the task
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

        return response()->json(['success' => true, 'message' => 'Task created successfully', 'task' => $task], 201);
    } catch (\Exception $e) {
        \Log::error('Error creating task: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Error creating task: ' . $e->getMessage()], 500);
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

    // // Fetch tasks assigned to the logged-in user (Fixed: Using auth()->id() instead of email)
    //  public function getEmployeeTasks()
    // {
    //     // Assuming the user is authenticated
    //     $user = auth()->user();

    //     // Fetch tasks for the logged-in employee
    //     $tasks = Task::where('employee_id', $user->id)->get();  // Replace 'employee_id' with the actual column in your tasks table

    //     // Return the tasks as a view or JSON response
    //     return view('employee.tasks', compact('tasks'));
    // }
 // Fetch all tasks assigned to the logged-in employee
    public function myTasks()
    {
        $tasks = Task::where('assigned_to', Auth::id())->get();
        return view('employee.task', compact('tasks'));
    }
  // Fetch a specific task when the employee clicks on a task
    public function viewTask($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }
    // // Show task details
    // public function show($taskId)
    // {
    //     try {
    //         $task = Task::findOrFail($taskId);
    //         return view('tasks.show', compact('task'));
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Error loading task details!'], 500);
    //     }
    // }
}
