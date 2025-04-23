<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task; // Add this line

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        return view('employee.dashboard'); // Make sure this view exists
    }
    public function getDashboardStats()
{
    $userId = auth()->id();

    $taskCount = Task::where('assigned_to', $userId)->count();
    $inProgressTasks = Task::where('assigned_to', $userId)->where('status', 'In Progress')->count();
    // $taskScore = EmployeeScore::where('user_id', $userId)->sum('points'); // Assuming score is stored in `EmployeeScore` model

    return response()->json([
        'task_count' => $taskCount,
        'in_progress_tasks' => $inProgressTasks,
        // 'task_score' => $taskScore,
    ]);
}

}
