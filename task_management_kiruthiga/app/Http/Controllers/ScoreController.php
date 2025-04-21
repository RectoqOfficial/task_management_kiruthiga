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


public function updateScore($task_id)
{
    $task = Task::findOrFail($task_id);
    
    // ✅ Log task update attempt
    \Log::info('Updating score for task:', [
        'task_id' => $task_id,
        'task_status' => $task->status,
        'completed_at' => $task->completed_at,
        'deadline' => $task->deadline
    ]);
    $score = Score::where('task_id', $task_id)->first();

    if (!$score) {
        $score = new Score();
        $score->task_id = $task->id;
        $score->redo_count = 0;
        $score->overdue_count = 0;
        $score->score = 100; // Default max score
    }

    if ($task->status == 'Completed' && $task->completed_at) {
        if ($task->completed_at > $task->deadline) {
            $score->overdue_count++;
            $score->score = 80;
        } else {
            $score->score = max(100 - ($score->redo_count * 10), 0);
        }
    } elseif ($task->status == 'Redo') {
        $score->redo_count++;
        $score->score = max(100 - ($score->redo_count * 10), 0);
    }

    $score->save();
      // ✅ Log successful score update
    \Log::info('Score updated successfully:', [
        'task_id' => $task->id,
        'new_score' => $score->score,
        'redo_count' => $score->redo_count,
        'overdue_count' => $score->overdue_count
    ]);
    return redirect()->route('scores.index')->with('success', 'Score updated successfully.');
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
                $task->score->score -= 5 * $overdueDays; // Decrease score based on overdue days
                $task->score->save();
            }
        }
    }

    \Log::info("Overdue tasks updated and score decreased.");
}





 public function showScoreboard()
    {
        $this->updateOverdueTasks(); // call it here temporarily

        $tasks = Task::with(['employee', 'score'])->get();

return view('admin.score', compact('tasks'));

    }
}
