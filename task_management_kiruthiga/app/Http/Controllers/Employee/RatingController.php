<?php
namespace App\Http\Controllers\Employee;

use App\Models\Task;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function index()
    {
        // Ensure the employee is authenticated
        if (!Auth::guard('employee')->check()) {
            return redirect()->route('employee.login')->with('error', 'Please log in to view your tasks.');
        }

        // Retrieve the authenticated employee
        $employee = Auth::guard('employee')->user();

        // Get tasks for the logged-in employee, using employee's ID for query
        $tasks = Task::where('assigned_to', $employee->id)
                     ->with('employee') // Ensures employee data is loaded along with the tasks
                     ->get();

        // Return the view with the necessary data
        return view('employee.my-rating', compact('tasks'));
    }
}
