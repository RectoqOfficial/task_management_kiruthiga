<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\Score;
use Carbon\Carbon;

class UpdateTaskScores extends Command
{
    protected $signature = 'tasks:update-scores';
    protected $description = 'Automatically updates overdue_count and reduces scores for overdue tasks';

    public function handle()
    {
        $tasks = Task::where('status', '!=', 'Completed')->get();

        foreach ($tasks as $task) {
            $score = Score::where('task_id', $task->id)->first();
            if (!$score) {
                continue;
            }

            // Check if task is overdue
            if (Carbon::now()->greaterThan($task->deadline)) {
                $score->overdue_count++;
                $score->score = max($score->score - 10, 0); // Reduce score by 10 per overdue
            }

            // Check if task is marked as "Redo"
            if ($task->status == 'Redo') {
                $score->redo_count++;
                $score->score = max($score->score - 10, 0); // Reduce score by 10 per redo
            }

            $score->save();
        }

        $this->info('Task overdue_count and redo_count updated successfully.');
    }
}
