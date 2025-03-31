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
    Route::resource('departments', DepartmentController::class);

    // Role Routes
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::resource('roles', RoleController::class);
});

// // Admin Routes (Protected by Auth Middleware)
// Route::middleware(['auth'])->prefix('admin')->group(function () {
//     // Department Routes
//     Route::resource('departments', DepartmentController::class);

//     // Role Routes
//     Route::resource('roles', RoleController::class);
// });
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});
// Employee Dashboard
Route::get('/employee/dashboard', [EmployeeDashboardController::class, 'index'])
    ->name('employee.dashboard')
    ->middleware('auth');


use App\Http\Controllers\EmployeeController;

Route::get('/admin/employees', [EmployeeController::class, 'index'])->name('employees.index');

Route::post('/admin/addEmployee', [EmployeeController::class, 'store'])->name('admin.addEmployee');

Route::get('/get-roles/{departmentId}', [EmployeeController::class, 'getRolesByDepartment']);


Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');


use App\Http\Controllers\TaskController;

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store');
Route::patch('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

Route::get('/get-roles-by-department', [TaskController::class, 'getRolesByDepartment'])->name('getRolesByDepartment');
Route::get('/get-employees-by-role/{role}', [TaskController::class, 'getEmployeesByRole']);

Route::match(['put', 'patch'], '/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');

use App\Http\Controllers\ScoreController;

Route::get('/scores', [ScoreController::class, 'index'])->name('scores.index');
Route::post('/scores/update/{task_id}', [ScoreController::class, 'updateScore'])->name('scores.update');

