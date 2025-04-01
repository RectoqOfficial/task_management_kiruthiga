<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AuthController;
// Login Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\EmployeeDashboardController;
Route::prefix('admin')->group(function () {
    // Department Routes
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
    Route::resource('departments', DepartmentController::class)->except(['index', 'store']); // Removing redundant routes

    // Role Routes
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::resource('roles', RoleController::class)->except(['index', 'store']); // Removing redundant routes
});


Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
Route::put('/departments/{id}', [DepartmentController::class, 'update'])->name('departments.update');


//admin middleware
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});
//employee middleware
Route::middleware('auth:employee')->group(function () {
    Route::get('/employee/dashboard', function () {
        return view('employee.dashboard');
    })->name('employee.dashboard');
});
// In routes/web.php
Route::get('/admin/departments', [DepartmentController::class, 'index'])->name('admin.departments');


use App\Http\Controllers\EmployeeController;


// Display employee list page


Route::get('/admin/employees', [EmployeeController::class, 'index'])->name('admin.employees');
// Add a new employee (This will be an AJAX route)
Route::post('/admin/employees/add', [EmployeeController::class, 'addEmployee'])->name('admin.addEmployee');

// Get roles based on selected department (This will be an AJAX route)
Route::get('/admin/employees/roles/{departmentId}', [EmployeeController::class, 'getRolesByDepartment'])->name('admin.getRolesByDepartment');

// Delete an employee (This will be an AJAX route)
Route::delete('/admin/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');



use App\Http\Controllers\TaskController;

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store');
Route::patch('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
Route::get('/task/{task}', [TaskController::class, 'show'])->name('tasks.show');
Route::middleware('auth', 'role:admin')->delete('/tasks/{task}', [TaskController::class, 'destroy']);

Route::get('/get-roles-by-department', [TaskController::class, 'getRolesByDepartment'])->name('getRolesByDepartment');
Route::get('/get-employees-by-role/{role}', [TaskController::class, 'getEmployeesByRole']);

Route::match(['put', 'patch'], '/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
Route::get('/my-tasks', [TaskController::class, 'myTasks'])->name('my.tasks');

use App\Http\Controllers\ScoreController;

Route::get('/scores', [ScoreController::class, 'index'])->name('scores.index');
Route::post('/scores/update/{task_id}', [ScoreController::class, 'updateScore'])->name('scores.update');

