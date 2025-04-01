<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Department;
use App\Models\Role;
use App\Models\Employee;
use App\Models\User;

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

    // Store a new task
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'task_title' => 'required|string|max:255',
            'description' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'role_id' => 'required|exists:roles,id',
            'assigned_to' => 'required|exists:employees,id',
            'task_start_date' => 'required|date',
            'no_of_days' => 'required|integer|min:1',
        ]);

        // Calculate the deadline date
        $deadline = date('Y-m-d', strtotime($request->task_start_date . ' + ' . $request->no_of_days . ' days'));

        try {
            // Create a new task
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

            // Return a JSON response indicating success
            return response()->json([
                'success' => true,
                'message' => 'Task created successfully',
                'task' => $task, // Optionally return the created task data
            ], 201); // 201 status code indicates a resource was created

        } catch (\Exception $e) {
            // Handle any errors that may occur during task creation
            \Log::error('Error creating task: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating task: ' . $e->getMessage(),
            ], 500); // 500 status code indicates a server error
        }
    }

    // Update an existing task's status
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);  // Find task by ID

        // Check if the logged-in user is an admin
        if (auth()->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update this task.',
            ], 403); // 403 Forbidden
        }

        // Validate the status
        $validated = $request->validate([
            'status' => 'required|string|in:Pending,Started,Completed,Review', // Status should be one of these
        ]);

        // Update task status
        $task->status = $validated['status'];
        $task->save();

        // Respond with success and return the updated task data
        return response()->json([
            'success' => true,
            'message' => 'Task status updated successfully.',
            'task' => $task, // Returning the updated task object
        ]);
    }

    // Delete a task
    public function destroy($id)
    {
        try {
            // Find the task by ID and delete it
            $task = Task::findOrFail($id);
            $task->delete();

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully',
            ], 200); // 200 status code for successful operation
        } catch (\Exception $e) {
            // Return error response if task is not found or there is an issue
            \Log::error('Error deleting task: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting task: ' . $e->getMessage(),
            ], 500); // 500 status code for internal server error
        }
    }

    // Get roles by department
    public function getRolesByDepartment(Request $request)
    {
        $roles = Role::where('department_id', $request->department_id)->get();
        return response()->json($roles);
    }

    // Get employees by role
    public function getEmployeesByRole(Request $request)
    {
        $roleId = $request->role_id;
        $employees = Employee::where('role_id', $roleId)
                             ->select('id', 'email') // Fetch email and id
                             ->get();

        return response()->json($employees);
    }

    // Fetch tasks assigned to the logged-in user
public function getTasks()
{
    // Check if the user is authenticated
    if (!auth()->check()) {
        return response()->json(['error' => 'User not authenticated'], 401);
    }

    // Fetch tasks assigned to the logged-in employee by their email
    $tasks = Task::where('assigned_to', auth()->user()->email)->get(); 

    // Return the tasks view
    return view('employee.task', compact('tasks'));
}



    // Show task details
    public function show($taskId)
    {
        try {
            $task = Task::findOrFail($taskId);
            return view('tasks.show', compact('task'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error loading task details!'], 500);
        }
    }
}
