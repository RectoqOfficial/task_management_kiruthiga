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
        // Get all tasks that are not completed
        $tasks = Task::where('status', '!=', 'Completed')->get();
        $now = now();

        foreach ($tasks as $task) {
            if ($task->task_start_date && $task->deadline && $task->no_of_days) {
                // Parse the deadline date
                $deadline = Carbon::parse($task->deadline);
                $overdue = 0;
                $score = 0;

                // Check if the deadline has passed
                if ($deadline->isPast()) {
                    // Calculate the difference in days between now and the deadline
                    $overdue = $deadline->diffInDays($now, false); // false will give a negative number if the deadline is in the past
                    $overdue = max($overdue, 0); // Ensure no negative overdue days
                }

                // Round the overdue days to the nearest whole number
                $overdue = floor($overdue);  // Or use ceil() if you want to round up to the nearest whole day.

                // Penalty: -30 points per overdue day
                $score = $overdue * -30;

                // Update the task's overdue_days and score fields
                $task->overdue_days = $overdue;
                $task->score = $score;
                $task->save();
            }
        }

        // Display message in the console
        $this->info('Overdue days and scores updated successfully!');
    }
}


//php artisan tasks:update-overdue