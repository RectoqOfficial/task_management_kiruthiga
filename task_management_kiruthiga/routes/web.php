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

// Admin Dashboard Route (Protected)
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('admin')->name('admin.dashboard');

// Employee Dashboard Route (Protected)
Route::get('/employee/dashboard', function () {
    return view('employee.dashboard');
})->middleware('employee')->name('employee.dashboard');
