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


// Admin Dashboard (Only for Admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Employee Dashboard (Only for Employee)
Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeController::class, 'index'])->name('employee.dashboard');
});

// Add the route for role details
Route::get('admin/role-details', [AdminController::class, 'roleDetails'])->name('admin.role.details');
// Add route for adding a new role
Route::get('admin/role/add', [AdminController::class, 'addRole'])->name('admin.role.add');
Route::post('admin/role/store', [AdminController::class, 'storeRole'])->name('admin.role.store');
