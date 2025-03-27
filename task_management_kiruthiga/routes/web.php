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

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/role-details', [AdminController::class, 'roleDetails'])->name('admin.role.details');
    Route::get('/admin/employee-details', [AdminController::class, 'employeeDetails'])->name('admin.employee.details');
    Route::get('/admin/task-details', [AdminController::class, 'taskDetails'])->name('admin.task.details');
    Route::get('/admin/scoreboard', [AdminController::class, 'scoreboard'])->name('admin.scoreboard');
});
//// Employee Routes
Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
    Route::get('/employee/tasks', [EmployeeController::class, 'myTasks'])->name('employee.tasks');
    Route::get('/employee/profile', [EmployeeController::class, 'profile'])->name('employee.profile');
    Route::get('/employee/scoreboard', [EmployeeController::class, 'scoreboard'])->name('employee.scoreboard');
});