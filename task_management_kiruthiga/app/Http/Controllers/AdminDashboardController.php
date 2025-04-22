<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Task;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin'); // Ensure only authenticated admins can access
    }

    public function index()
    {
        // Log the authenticated admin
        Log::info('Authenticated Admin:', ['user' => Auth::guard('admin')->user()]);

        $departments = Department::with('roles')->get();
        return view('admin.dashboard', compact('departments'));
    }

    public function dashboard()
    {
        // Fetch task data from the database
        $totalTasks = Task::count();
        $pendingTasks = Task::where('status', 'pending')->count();
        $startedTasks = Task::where('status', 'started')->count();
        $completedTasks = Task::where('status', 'completed')->count();
        $reviewTasks = Task::where('status', 'review')->count();

        // Calculate the top performers for different time periods
        $top3Months = $this->getTopPerformer(Carbon::now()->subMonths(3));
        $top6Months = $this->getTopPerformer(Carbon::now()->subMonths(6));
        $top1Year = $this->getTopPerformer(Carbon::now()->subYear());

        // Pass variables to the view
        return view('admin.dashboard', compact(
            'totalTasks',
            'pendingTasks',
            'startedTasks',
            'completedTasks',
            'reviewTasks',
            'top3Months',
            'top6Months',
            'top1Year'
        ));
    }

    // Helper function to get top performer based on completed tasks in a given time range
    private function getTopPerformer($fromDate)
    {
        return Task::where('status', 'completed')
            ->whereNotNull('completed_at')
            ->where('completed_at', '>=', $fromDate)
            ->selectRaw('assigned_to, COUNT(*) as completed_count')
            ->groupBy('assigned_to')
            ->orderByDesc('completed_count')
            ->with('employee') // assuming 'employee' relationship exists
            ->first();
    }
}
