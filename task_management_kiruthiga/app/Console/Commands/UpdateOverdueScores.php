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
$tasksWithNoScores = Task::doesntHave('score')->get();

        if ($tasksWithNoScores->isNotEmpty()) {
            $this->info('Tasks without score records:');
            foreach ($tasksWithNoScores as $task) {
                $this->info("Task ID: {$task->id}");
            }
        }

        foreach ($tasks as $task) {
            if (!$task->taskScore) {
                $this->warn("⚠️ No score record for Task ID: {$task->id}");
                continue;
            }

            $this->info("Task #{$task->id} - Score: {$task->taskScore->score}, Overdue Count: {$task->taskScore->overdue_count}");

            if ($task->deadline && Carbon::parse($task->deadline)->lt($today)) {
                $totalOverdueDays = $today->diffInDays(Carbon::parse($task->deadline));
                $newOverdueDays = $totalOverdueDays - $task->taskScore->last_overdue_count;

                if ($newOverdueDays > 0) {
                    $task->taskScore->overdue_count = $totalOverdueDays;

                    $scoreReduction = $newOverdueDays * 5;
                    $newScore = $task->taskScore->score - $scoreReduction;
                    $task->taskScore->score = max(0, $newScore);

                    $task->taskScore->last_overdue_count = $totalOverdueDays;

                    $task->taskScore->save();

                    $this->info("✅ Task #{$task->id} | New Overdue: {$newOverdueDays} days | Score: {$task->taskScore->score}");
                } else {
                    $this->line("⏩ Task #{$task->id} already processed for {$totalOverdueDays} overdue days.");
                }
            }
        }

        $this->info('🎯 Overdue counts and scores updated successfully.');
    }
} 
