<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AuthController;
// Login Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Dashboard Routes (Protect them with middleware if needed)
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/employee/dashboard', function () {
    return view('employee.dashboard');
})->name('employee.dashboard');

// use App\Http\Controllers\RoleDetailController;

// Route::get('/admin/role-details', [RoleDetailController::class, 'index'])->name('admin.role.details');
// Route::post('/roles/store', [RoleDetailController::class, 'store'])->name('role.store');
// Route::delete('/roles/{id}', [RoleDetailController::class, 'destroy'])->name('role.destroy');


// use App\Http\Controllers\EmployeeDetailController;

// Route::get('/employees', [EmployeeDetailController::class, 'index'])->name('employees.index');
// Route::get('/employees/create', [EmployeeDetailController::class, 'create'])->name('employees.create');
// Route::post('/employees', [EmployeeDetailController::class, 'store'])->name('employees.store');

// routes/web.php

use App\Http\Controllers\TaskController;

Route::get('/tasks', [TaskController::class, 'index']);  // Display tasks
Route::post('/tasks', [TaskController::class, 'store']);  // Store new task
Route::get('tasks/score_details', [TaskController::class, 'showScoreboard'])->name('tasks.score_details');
Route::post('tasks/update_status/{taskId}', [TaskController::class, 'updateTaskStatus'])->name('tasks.update_status');
// In your routes/web.php
Route::get('/tasks', function() {
    return view('tasks.task_details'); // Path to the view you want to load
});
Route::get('/tasks/score_details', [TaskController::class, 'showScoreDetails']);


use App\Http\Controllers\RoleDetailController;

// Route to view the role details page
Route::get('/roles', [RoleDetailController::class, 'index'])->name('roles');

// Route to handle the storing of new roles
Route::post('/roles', [RoleDetailController::class, 'store'])->name('role_details.store');

// Route to handle the deletion of roles
Route::delete('/roles/{id}', [RoleDetailController::class, 'destroy'])->name('role_details.destroy');
use App\Models\RoleDetail;

Route::get('/roles', function () {
    // Fetch all roles
    $roles = RoleDetail::all(); // You can modify this to add any filters if needed
    return view('tasks.role_detail', compact('roles')); // Pass the $roles variable to the view
});



use App\Http\Controllers\EmployeeDetailController;

Route::get('/employee-details', [EmployeeDetailController::class, 'index'])->name('employee_details.index');
Route::post('/employee-details/store', [EmployeeDetailController::class, 'store'])->name('employee_details.store');
Route::delete('/employee-details/{id}', [EmployeeDetailController::class, 'destroy']);


Route::prefix('employee-details')->name('employee_details.')->group(function() {
    // Display employee details form and employee list
    Route::get('/', [EmployeeDetailController::class, 'index'])->name('index');
    
    // Store new employee details
    Route::post('/', [EmployeeDetailController::class, 'store'])->name('store');
    
    // Delete an employee by their ID
    Route::delete('{id}', [EmployeeDetailController::class, 'destroy'])->name('destroy');
});


