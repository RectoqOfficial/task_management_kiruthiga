<?php
// app/Http/Controllers/TaskController.php

namespace App\Http\Controllers;
use App\Models\RoleDetail;
use App\Models\EmployeeDetail; 
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function showTaskDetails()
    {
        $roleDetails = RoleDetail::all();

        // Ensure both variables are collections
        $departments = $roleDetails->pluck('department')->unique();
        $roles = $roleDetails->pluck('role')->unique();

        // Fetch employees who belong to the available departments & roles
        $employees = EmployeeDetail::whereIn('department', $departments)
                                   ->whereIn('role_id', RoleDetail::pluck('id'))
                                   ->get();

        return view('tasks.task_details', compact('departments', 'roles', 'employees'));
    }

    public function fetchRoles(Request $request)
    {
        $roles = RoleDetail::where('department', $request->department)
                           ->pluck('role')
                           ->unique()
                           ->values();

        return response()->json($roles);
    }

    public function fetchEmployees(Request $request)
    {
        $employees = EmployeeDetail::where('department', $request->department)
                                   ->whereHas('role', function($query) use ($request) {
                                       $query->where('role', $request->role);
                                   })
                                   ->get(['id', 'fullname', 'email']);

        return response()->json($employees);
    }

    public function store(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'task_title' => 'required|string|max:255',
            'description' => 'required|string',
            'department' => 'required|string',
            'role' => 'required|string',
            'assigned_to' => 'required|integer',
            'no_of_days' => 'required|integer',
            'task_create_date' => 'required|date',
            'task_start_date' => 'required|date',
            'deadline' => 'required|date',
        ]);

        // Store the task
        $task = Task::create($validated);

        // Get the assigned employee's name
        $employee = EmployeeDetail::find($task->assigned_to); // Use EmployeeDetail for getting employee info
        if ($employee) {
            $task->assigned_to_name = $employee->fullname;
        } else {
            $task->assigned_to_name = 'Unknown Employee';
        }

        return response()->json($task);
    }

    public function destroy($id)
    {
        Task::find($id)->delete();
        return response()->json(['success' => true]);
    }

    //score board code 
   public function showScoreboard()
{
    $tasks = Task::with('scoreDetails')->get(); // Fetch tasks with related score details
    return view('tasks.score_details', compact('tasks'));
}
     public function updateTaskStatus(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $redoCount = $task->scoreDetails->count(); // Assuming you track the number of redo attempts
        $isOverdue = now()->gt($task->deadline); // Check if the task is overdue

        // Calculate the score
        $score = ScoreDetail::calculateScore($redoCount, $isOverdue);

        // Create a new score detail record
        ScoreDetail::create([
            'task_id' => $task->id,
            'redo_count' => $redoCount,
            'overdue' => $isOverdue,
            'score' => $score,
            'history' => now(), // Store the date/time of the redo or overdue
        ]);

        return back()->with('success', 'Task status updated and score recorded.');
    }


    //scoreboard 
public function showScoreDetails()
{
    // Assuming you have a Task model that holds your task data
    $tasks = Task::all(); // Fetch all tasks, or apply any necessary query here

    // Pass the tasks to the view
    return view('tasks.score_details', compact('tasks'));
}


}
