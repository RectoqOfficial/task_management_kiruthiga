<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Task;
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

    // Pass variables to the view
    return view('admin.dashboard', compact(
        'totalTasks',
        'pendingTasks',
        'startedTasks',
        'completedTasks',
        'reviewTasks'
    ));
}

}
