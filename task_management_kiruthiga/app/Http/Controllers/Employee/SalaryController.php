<?php
namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SalaryController extends Controller
{
    public function index()
    {
        // Ensure the employee is authenticated
        if (!Auth::guard('employee')->check()) {
            return redirect()->route('employee.login')->with('error', 'Please log in to view your salary details.');
        }

        // Retrieve the authenticated employee
        $employee = Auth::guard('employee')->user();

        // Get tasks for the logged-in employee, using employee's ID for query
        $tasks = Task::where('assigned_to', $employee->id)
                     ->with('employee') // Ensures employee data is loaded along with the tasks
                     ->get();

        // Array to hold salary data for each task
        $salaryData = [];

        foreach ($tasks as $task) {
            $startDate = Carbon::parse($task->task_start_date);
            $deadline = Carbon::parse($task->deadline);
            $completedDate = $task->status == 'Completed' ? Carbon::parse($task->updated_at) : null;

            // Base salary per task = 10% (you can change this base salary logic based on your system)
            $baseSalary = 1000; // Example base salary, assume total is 1000
            $taskSalary = $baseSalary * 0.10;

            // Overdue days calculation
        $now = $task->status == 'Completed' ? $completedDate : now();
$now = $task->status == 'Completed' ? Carbon::parse($task->updated_at) : now();
$overdue = 0;
if ($deadline->lt($now)) {
    $overdue = floor($deadline->floatDiffInRealDays($now)); // No decimals, rounded down
}


            // Salary reduction: 1% per day late, max 9% reduction
            $penalty = $taskSalary * (min($overdue, 9) * 0.01); // Max 9% reduction
            $finalSalary = max($taskSalary - $penalty, 0);

            // Collect salary data
            $salaryData[] = [
                'task_id' => $task->id,
                'task_title' => $task->task_title,
                'status' => $task->status,
                'start_date' => $task->task_start_date,
                'deadline' => $task->deadline,
                'overdue_days' => $overdue,
                'salary' => round($finalSalary, 2),
            ];
        }

        // Return the view with the salary data
        return view('employee.my-salary', compact('salaryData'));
    }
}
