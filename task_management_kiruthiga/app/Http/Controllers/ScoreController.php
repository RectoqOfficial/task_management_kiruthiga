<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Score;

class ScoreController extends Controller
{
   public function index()
{
    // Fetch all tasks and join with scores
    $tasks = Task::with('score')->get();

    return view('admin.score', compact('tasks'));
}


// Update Score for Task
public function updateScore(Request $request, $taskId)
{
    $task = Task::find($taskId);
    
    if (!$task) {
        return redirect()->back()->with('error', 'Task not found');
    }

    // Logic to calculate the score based on task status, redo_count, and overdue_count
    $score = Score::where('task_id', $task->id)->first();
    
    if (!$score) {
        $score = new Score();
        $score->task_id = $task->id;
    }

    // Check if task is completed by employee
    if ($task->status === 'Completed') {
        $score->score = $request->score ?? 50;  // Default score for completion

        // Check if redo count exists, and subtract 20 points for each redo
        $score->score -= $task->redo_count * 20;

        // Check if the task is overdue
        $deadline = Carbon::parse($task->deadline);
        $currentDate = Carbon::now();
        if ($currentDate->gt($deadline)) {
            $overdueDays = $currentDate->diffInDays($deadline);
            $score->score -= $overdueDays * 30; // Subtract 30 points per overdue day
            $score->overdue_count = $overdueDays;
        }

        // Ensure score doesn't go negative
        $score->score = max(0, $score->score);
    }

    // Save score updates
    $score->save();

    // Return updated score to the frontend
    return response()->json([
        'score' => $score->score,
        'message' => 'Score updated successfully',
    ]);
}


   public function myScore()
{
    if (!Auth::guard('employee')->check()) {
        return redirect()->route('employee.login')->with('error', 'Please log in to view your score.');
    }

    $employee = Auth::guard('employee')->user();
    $tasks = Task::with('score')->where('assigned_to', $employee->id)->get();

    return view('employee.score', compact('tasks'));
}
// app/Http/Controllers/ScoreController.php

public function updateOverdueTasks()
{
    $tasks = Task::with('score')
        ->where('status', 'Completed')
        ->where('deadline', '<', now())
        ->get();

    foreach ($tasks as $task) {
        // Calculate overdue days
        $overdueDays = now()->diffInDays($task->deadline);

        if ($overdueDays > 0) {
            if ($task->score) {
                $task->score->overdue_count = $overdueDays;
                $task->score->score -= 20 * $overdueDays; // Decrease score based on overdue days
                $task->score->save();
            }
        }
    }

    \Log::info("Overdue tasks updated and score decreased.");
}


public function redoTask(Request $request)
{
    $task = Task::with('score')->find($request->task_id);

    if ($task && $task->score) {
        // Increment redo count
        $task->redo_count += 1;

        // Decrease the score in the related Score model
        $task->score->score -= 20;
        $task->score->save(); // Save the related Score model

        $task->status = "Pending"; // Update status to Pending
        $task->save(); // Save the task model

        return response()->json([
            'redo_count' => $task->redo_count,
            'status' => $task->status,
            'score' => $task->score->score, // Access the updated score
        ]);
    }

    return response()->json(['error' => 'Task not found!'], 404);
}



//  public function showScoreboard()
//     {
//         $this->updateOverdueTasks(); // call it here temporarily

//         $tasks = Task::with(['employee', 'score'])->get();

// return view('admin.score', compact('tasks'));

//     }
}
