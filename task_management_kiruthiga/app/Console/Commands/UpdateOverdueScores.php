<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Carbon\Carbon;

class UpdateOverdueScores extends Command
{
    protected $signature = 'tasks:update-overdue-scores';
    protected $description = 'Update overdue counts and reduce scores for tasks past deadline';

    public function handle()
    {
        $today = Carbon::today();

        $tasks = Task::with('score')->where('status', '!=', 'Completed')->get();

        foreach ($tasks as $task) {
            if ($task->deadline && Carbon::parse($task->deadline)->lt($today)) {
                $daysOverdue = $today->diffInDays(Carbon::parse($task->deadline));

                $task->score->overdue_count = $daysOverdue;
                $task->score->score = max(0, 100 - (($task->score->redo_count * 10) + ($daysOverdue * 5)));
                $task->score->save();
            }
        }

        $this->info('Overdue counts and scores updated successfully.');
    }
}
