<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Department;
use App\Models\Role;
use App\Models\Employee;
use App\Models\User;
use App\Models\Score; 

use Carbon\Carbon;


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
public function show($id)
{
    return redirect()->route('tasks.index');
}


public function store(Request $request)
{
    \Log::info('Task creation request:', $request->all());

    // ✅ Validate input
    $request->validate([
        'task_title'     => 'required|string|max:255',
        'description'    => 'required|string',
        'department_id'  => 'required|exists:departments,id',
        'role_id'        => 'required|exists:roles,id',
        'assigned_to'    => 'required|exists:employees,id',
        'task_start_date'=> 'nullable|date',
        'no_of_days'     => 'required|integer|min:1',
    ]);

    // ✅ Calculate Deadline
    $taskStartDate = $request->task_start_date ? new \DateTime($request->task_start_date) : new \DateTime();
    $noOfDays = $request->no_of_days;

    try {
        $taskStartDate->modify("+$noOfDays days")->modify("-1 day");
        $deadline = $taskStartDate->format('Y-m-d');
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error calculating the deadline',
        ], 400);
    }

    try {
        // ✅ Create the task
        $task = Task::create([
            'task_title'      => $request->task_title,
            'description'     => $request->description,
            'department_id'   => $request->department_id,
            'role_id'         => $request->role_id,
            'assigned_to'     => $request->assigned_to,
            'task_create_date'=> now()->format('Y-m-d'),
            'task_start_date' => $request->task_start_date,
            'no_of_days'      => $request->no_of_days,
            'deadline'        => $deadline,
            'status'          => 'Pending',
        ]);

        // ✅ Create the initial score
        Score::create([
            'task_id'      => $task->id,
            'redo_count'   => 0,
            'overdue_count'=> 0,
            'score'        => $request->score ?? 0, // Default to 0 if not provided
        ]);

        $employee = Employee::find($request->assigned_to);

        // ✅ Return success response with HTTP 200
        return response()->json([
            'success'  => true,
            'message'  => 'Task created successfully',
            'task'     => $task,
            'employee' => $employee,
            'score'    => [
                'redo_count'   => 0,
                'overdue_count'=> 0,
                'score'        => $request->score ?? 0,
            ]
        ], 200); // 🔥 Changed from 201 to 200 to fix the JS error

    } catch (\Exception $e) {
        \Log::error('Error creating task: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error creating task',
        ], 500);
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

        // ✅ If status is changed to Completed and it's not already completed
        if ($request->status === 'Completed' && $task->completed_at === null) {
            $task->completed_at = now();
        }

        $task->status = $request->status;
        $task->save();

        return response()->json([
            'success' => true,
            'status' => $task->status,
            'completed_at' => $task->completed_at ? $task->completed_at->format('d M Y, h:i A') : null
        ]);
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


//redo count
public function redoTask(Request $request)
{
    $task = Task::find($request->task_id);

    if ($task) {
        // Increment redo count
        $task->redo_count += 1;

        // Decrease the task's score
        $task->score -= 20; // Directly updating 'score' field
        $task->status = "Pending"; // Update status to Pending

        // Save the changes
        $task->save();

        return response()->json([
            'redo_count' => $task->redo_count,
            'status' => $task->status,
            'score' => $task->score,
        ]);
    }

    return response()->json(['error' => 'Task not found!'], 404);
}




// app/Http/Controllers/TaskController.php
public function updateOverdueTasks()
{
    $tasks = Task::where('status', '!=', 'Completed')->get();

    foreach ($tasks as $task) {
        if ($task->task_start_date && $task->deadline && $task->no_of_days) {
            $deadline = Carbon::parse($task->deadline);
            $now = now();
            $overdue = 0;

            if ($deadline->isPast()) {
                $overdue = floor($deadline->floatDiffInRealDays($now));
                $overdue = max($overdue, 0);
            }

            $task->overdue_days = $overdue; // Make sure this column exists in your DB
            $task->save();
        }
    }

    return response()->json(['message' => 'Overdue days updated successfully.']);
}


public function showScoreboard()
{
    $tasks = Task::with('employee')->get();

    // Iterate through each task and dump the associated employee
    foreach ($tasks as $task) {
        dd($task->employee);  // Check each task's employee relationship
    }

    return view('scoreboard', compact('tasks'));
}


public function updateScore(Request $request, $id)
{
    $request->validate([
        'score' => 'required|integer|min:0'
    ]);

    $task = Task::findOrFail($id);
    $task->score = $request->score;
    $task->save();

    return back()->with('success', 'Score updated successfully!');
}

// Upload Task Document
public function uploadDocument(Request $request, Task $task)
{
    $request->validate([
        'task_document' => 'required|file|mimes:pdf,docx,jpg,jpeg,png|max:2048',
    ]);

    // Store the file and get the path
    $file = $request->file('task_document');
    $path = $file->store('documents/task_docs', 'public');
    
    // Save the file path to the task record
    $task->task_document = $path;
    $task->save();

    // Return JSON response for AJAX requests
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'file_url' => asset('storage/' . $path),
            'file_name' => $file->getClientOriginalName(), // Return the original file name
            'message' => 'Task Document uploaded successfully.',
        ]);
    }

    // Redirect back for normal requests
    return back()->with('success', 'Task Document uploaded successfully.');
}

// Upload Flowchart
public function uploadFlowchart(Request $request, Task $task)
{
    $request->validate([
        'flowchart' => 'required|file|mimes:pdf,docx,jpg,jpeg,png|max:2048',
    ]);

    // Store the file and get the path
    $file = $request->file('flowchart');
    $path = $file->store('documents/flowcharts', 'public');
    
    // Save the file path to the task record
    $task->flowchart = $path;
    $task->save();

    // Return JSON response for AJAX requests
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'file_url' => asset('storage/' . $path),
            'file_name' => $file->getClientOriginalName(),
            'message' => 'Flowchart uploaded successfully.',
        ]);
    }

    // Redirect back for normal requests
    return back()->with('success', 'Flowchart uploaded successfully.');
}

// Upload Sheet Detail
public function uploadSheet(Request $request, Task $task)
{
    $request->validate([
        'sheet_detail' => 'required|file|mimes:pdf,docx,jpg,jpeg,png|max:2048',
    ]);

    // Store the file and get the path
    $file = $request->file('sheet_detail');
    $path = $file->store('documents/sheets', 'public');
    
    // Save the file path to the task record
    $task->sheet_detail = $path;
    $task->save();

    // Return JSON response for AJAX requests
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'file_url' => asset('storage/' . $path),
            'file_name' => $file->getClientOriginalName(),
            'message' => 'Sheet detail uploaded successfully.',
        ]);
    }

    // Redirect back for normal requests
    return back()->with('success', 'Sheet detail uploaded successfully.');
}
public function uploadFeedback(Request $request, $id)
{
    $task = Task::findOrFail($id);

    // Handle file upload if it exists
    if ($request->hasFile('feedback_image')) {
        $image = $request->file('feedback_image')->store('feedbacks', 'public');
        $task->feedback_image = $image;
    }

    // Update feedback note
    $task->feedback_note = $request->feedback_note;

    // Set the feedback_updated flag to true
    $task->feedback_updated = true;

    // Save task
    $task->save();

    return back()->with('success', 'Feedback uploaded successfully!');
}


}
