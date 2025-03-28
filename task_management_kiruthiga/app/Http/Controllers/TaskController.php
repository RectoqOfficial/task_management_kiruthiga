<?php
// app/Http/Controllers/TaskController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index() {
        $tasks = Task::all(); // Fetch tasks from database
        return view('tasks.task_details', compact('tasks'));
    }

    public function store(Request $request) {
        // Store task logic (validation, save to database)
    }
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
public function showScoreDetails()
{
    // Assuming you have a Task model that holds your task data
    $tasks = Task::all(); // Fetch all tasks, or apply any necessary query here

    // Pass the tasks to the view
    return view('tasks.score_details', compact('tasks'));
}


}
