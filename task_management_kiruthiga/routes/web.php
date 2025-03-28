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

use App\Http\Controllers\RoleDetailController;

Route::get('/admin/role-details', [RoleDetailController::class, 'index'])->name('admin.role.details');
Route::post('/roles', [RoleDetailController::class, 'store'])->name('role.store');
Route::delete('/roles/{id}', [RoleDetailController::class, 'destroy'])->name('role.destroy');


use App\Http\Controllers\EmployeeDetailController;

Route::get('/employees', [EmployeeDetailController::class, 'index'])->name('employees.index');
Route::get('/employees/create', [EmployeeDetailController::class, 'create'])->name('employees.create');
Route::post('/employees', [EmployeeDetailController::class, 'store'])->name('employees.store');
