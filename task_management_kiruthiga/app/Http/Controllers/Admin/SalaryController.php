<?php
// File: app/Http/Controllers/Admin/SalaryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Employee;
use Carbon\Carbon;

class SalaryController extends Controller
{
   public function index()
{
    $tasks = Task::with('employee')->get();
    $salaryData = [];

    foreach ($tasks as $task) {
        $startDate = Carbon::parse($task->task_start_date);
        $deadline = Carbon::parse($task->deadline);
        $completedDate = $task->status == 'Completed' ? Carbon::parse($task->updated_at) : null;
        $employeeName = $task->employee->full_name ?? 'Unknown';

        // Base salary per task
        $baseSalary = 1000;
        $taskSalary = $baseSalary * 0.10;

        // Overdue days calculation
        $now = $task->status == 'Completed' ? $completedDate : now();
$now = $task->status == 'Completed' ? Carbon::parse($task->updated_at) : now();
$overdue = 0;
if ($deadline->lt($now)) {
    $overdue = floor($deadline->floatDiffInRealDays($now)); // No decimals, rounded down
}




        // Salary reduction: 1% per overdue day
        $penalty = $taskSalary * (min($overdue, 9) * 0.01);
        $finalSalary = max($taskSalary - $penalty, 0);

        $salaryData[] = [
            'employee' => $employeeName,
            'task_id' => $task->id,
            'task_title' => $task->task_title,
            'status' => $task->status,
            'start_date' => $task->task_start_date,
            'deadline' => $task->deadline,
            'overdue_days' => $overdue,
            'salary' => round($finalSalary, 2),
        ];
    }

    return view('admin.salary-details', compact('salaryData'));
}

}
