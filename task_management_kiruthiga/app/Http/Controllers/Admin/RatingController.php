<?php
namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        // Fetch all tasks and employee details
        $tasks = Task::with('employee') // Eager loading employee relationship
                     ->get();

        return view('admin.rating', compact('tasks'));
    }

public function updateRating(Request $request, $taskId)
{
    // Validate rating input
    $request->validate([
        'rating' => 'required|integer|between:1,5', // Ensure rating is between 1 and 5
    ]);

    // Find the task and update the rating column
    $task = Task::findOrFail($taskId);
    
    // Update the rating column (not the score)
    $task->rating = $request->input('rating'); // Update the 'rating' column, not 'score'
    
    // Save the updated task
    $task->save();

    // Redirect back with success message
    return redirect()->route('admin.employee-rating')->with('success', 'Task rating updated!');
}


    
}
