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

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');
});

use App\Http\Controllers\EmployeeController;

Route::get('/admin/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::post('/admin/employees', [EmployeeController::class, 'store'])->name('employees.store');

Route::get('/get-roles/{department_id}', [EmployeeController::class, 'getRolesByDepartment']);
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');


use App\Http\Controllers\TaskController;

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store');
Route::patch('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

Route::get('/get-roles-by-department', [TaskController::class, 'getRolesByDepartment'])->name('getRolesByDepartment');
Route::get('/get-employees-by-role', [TaskController::class, 'getEmployeesByRole'])->name('getEmployeesByRole');
Route::match(['put', 'patch'], '/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
