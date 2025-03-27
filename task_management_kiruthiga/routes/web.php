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


use App\Http\Controllers\RoleDetailsController;

Route::get('/admin/role-details', [RoleDetailsController::class, 'index'])->name('role.index');
Route::post('/admin/role-details/store', [RoleDetailsController::class, 'store'])->name('role.store');
Route::delete('/admin/role-details/delete/{id}', [RoleDetailsController::class, 'destroy'])->name('role.destroy');

