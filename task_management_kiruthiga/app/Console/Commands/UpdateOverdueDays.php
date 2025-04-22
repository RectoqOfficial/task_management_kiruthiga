<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Carbon\Carbon;

class UpdateOverdueDays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * You can run this using: php artisan tasks:update-overdue
     */
    protected $signature = 'tasks:update-overdue';

    /**
     * The console command description.
     */
    protected $description = 'Update overdue_days and score field for tasks based on deadline and current date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Task::where('status', '!=', 'Completed')->get();
        $now = now();

        foreach ($tasks as $task) {
            if ($task->task_start_date && $task->deadline && $task->no_of_days) {
                $deadline = Carbon::parse($task->deadline);
                $overdue = 0;
                $score = 0;

                if ($deadline->isPast()) {
                    $overdue = floor($deadline->floatDiffInRealDays($now));
                    $overdue = max($overdue, 0);
                }

                // Penalty: -30 points per overdue day
                $score = $overdue * -30;

                // Update task values
                $task->overdue_days = $overdue;
                $task->score = $score;
                $task->save();
            }
        }

        $this->info('Overdue days and scores updated successfully!');
    }
}
