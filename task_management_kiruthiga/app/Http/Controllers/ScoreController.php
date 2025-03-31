<?php
namespace App\Http\Controllers;

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
        $score = Score::where('task_id', $task_id)->first();

        if (!$score) {
            $score = new Score();
            $score->task_id = $task->id;
            $score->redo_count = 0;
            $score->overdue_count = 0;
        }

        // Score Calculation
        if ($task->status == 'Completed') {
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
        return redirect()->route('scores.index')->with('success', 'Score updated successfully.');
    }
}
