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

        // Get all tasks that are not completed
        $tasks = Task::with('score')->where('status', '!=', 'Completed')->get();

        foreach ($tasks as $task) {
            // Skip if task has no score relationship
            if (!$task->score) {
                $this->warn("⚠️ No score record for Task ID: {$task->id}");
                continue;
            }

            // Only apply logic if the deadline is in the past
            if ($task->deadline && Carbon::parse($task->deadline)->lt($today)) {
                $totalOverdueDays = $today->diffInDays(Carbon::parse($task->deadline));
                $newOverdueDays = $totalOverdueDays - $task->score->last_overdue_count;

                if ($newOverdueDays > 0) {
                    // Update overdue_count
                    $task->score->overdue_count = $totalOverdueDays;

                    // Deduct score only for NEW overdue days, ensuring the score does not go below zero
                    $scoreReduction = $newOverdueDays * 5;
                    $newScore = $task->score->score - $scoreReduction;
                    $task->score->score = max(0, $newScore);  // Ensure score does not go below zero

                    // Update last_overdue_count so we don't subtract again for the same days
                    $task->score->last_overdue_count = $totalOverdueDays;

                    $task->score->save();

                    $this->info("✅ Task #{$task->id} | New Overdue: {$newOverdueDays} days | Score: {$task->score->score}");
                } else {
                    $this->line("⏩ Task #{$task->id} already processed for {$totalOverdueDays} overdue days.");
                }
            }
        }

        $this->info('🎯 Overdue counts and scores updated successfully.');
    }
}

//php artisan tasks:update-overdue-scores