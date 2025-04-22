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
// Employee Authentication Routes
Route::get('/employee/login', [AuthController::class, 'showLogin'])->name('employee.login');
Route::post('/employee/login', [AuthController::class, 'login'])->name('employee.login.submit');




// Department Routes

use App\Http\Controllers\DepartmentController;
Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
Route::resource('departments', DepartmentController::class)->except(['index', 'store']); // Removing redundant routes
Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
Route::put('/departments/{id}', [DepartmentController::class, 'update'])->name('departments.update');



// Role Routes
use App\Http\Controllers\RoleController;
Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
Route::resource('roles', RoleController::class)->except(['index', 'store']); // Removing redundant routes
Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');


use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\EmployeeDashboardController;
//admin middleware
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});
Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');

//employee middleware
Route::middleware('auth:employee')->group(function () {
    Route::get('/employee/dashboard', function () {
        return view('employee.dashboard');
    })->name('employee.dashboard');
});Route::get('/employee/dashboard/stats', [EmployeeDashboardController::class, 'getDashboardStats'])
     ->name('employee.dashboard.stats');

// In routes/web.php
Route::get('/admin/departments', [DepartmentController::class, 'index'])->name('admin.departments');


use App\Http\Controllers\EmployeeController;

// Routes for the employee management and AJAX actions
Route::get('/admin/employees', [EmployeeController::class, 'index'])->name('admin.employees');
Route::post('/admin/employees/add', [EmployeeController::class, 'addEmployee'])->name('admin.addEmployee');
Route::get('/admin/employees/roles/{departmentId}', [EmployeeController::class, 'getRolesByDepartment'])->name('admin.getRolesByDepartment');
Route::delete('/admin/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
Route::get('/employees/filter', [EmployeeController::class, 'filterEmployees'])->name('employees.filter');
Route::get('/employee/profile', [EmployeeController::class, 'profile'])->name('employee.profile');
Route::get('/employee/task-stats', [EmployeeController::class, 'getEmployeeTaskStats']);
Route::get('/employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
Route::get('/admin/employees', [EmployeeController::class, 'employeeList'])->name('admin.employeeList');
Route::post('/admin/check-email', [EmployeeController::class, 'checkEmail'])->name('admin.checkEmail');





use App\Http\Controllers\TaskController;
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store');

Route::patch('/tasks/{id}/update-status', [TaskController::class, 'updateStatus']);
// web.php
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');

Route::get('/get-roles-by-department', [TaskController::class, 'getRolesByDepartment'])->name('getRolesByDepartment');
Route::get('/employees-by-role', [TaskController::class, 'getEmployeesByRole'])->name('getEmployeesByRole');
Route::get('/get-employees-by-role', [TaskController::class, 'getEmployeesByRole'])->name('getEmployeesByRole');

Route::match(['put', 'patch'], '/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
Route::get('/employee/tasks', [TaskController::class, 'myTasks'])->name('employee.tasks');
Route::get('/employee/task/{id}', [TaskController::class, 'viewTask'])->name('employee.task.view');
Route::post('/employee/task/update-status/{id}', [TaskController::class, 'updateStatus']);
Route::post('/employee/task/update-start-date/{id}', [TaskController::class, 'updateStartDate']);
Route::delete('/employee/task/delete/{id}', [TaskController::class, 'deleteTask']);
Route::post('/employee/task/update-deadline/{id}', [TaskController::class, 'updateDeadline']);
Route::post('/tasks/{id}/update-remarks', [TaskController::class, 'updateRemarks'])->name('tasks.updateRemarks');
Route::get('/scoreboard', [TaskController::class, 'showScoreboard'])->name('scoreboard');


Route::post('/tasks/redo', [TaskController::class, 'redoTask'])->name('tasks.redo');

Route::post('/tasks/{id}/update-score', [TaskController::class, 'updateScore'])->name('tasks.updateScore');
Route::post('/tasks/{task}/upload-document', [TaskController::class, 'uploadDocument'])->name('tasks.uploadDocument');
Route::post('/tasks/{task}/upload-flowchart', [TaskController::class, 'uploadFlowchart'])->name('tasks.uploadFlowchart');
Route::post('/tasks/{task}/upload-sheet', [TaskController::class, 'uploadSheet'])->name('tasks.uploadSheet');
Route::get('/update-overdue', [TaskController::class, 'updateOverdueTasks']);
Route::post('/tasks/{id}/upload-feedback', [TaskController::class, 'uploadFeedback'])->name('tasks.uploadFeedback');
Route::post('/admin/tasks/update-status/{id}', [TaskController::class, 'updateStatus']);



use App\Http\Controllers\ScoreController;

Route::get('/scores', [ScoreController::class, 'index'])->name('scores.index');
Route::post('/scores/update/{task_id}', [ScoreController::class, 'updateScore'])->name('scores.update');

Route::get('/employee/score', [ScoreController::class, 'myScore'])->name('employee.score');
// Route::get('/scoreboard', [ScoreController::class, 'showScoreboard'])->name('scoreboard');



// routes/web.php

use App\Http\Controllers\Admin\LeaveController as AdminLeaveController;


Route::get('admin/leave/approve/{id}', [AdminLeaveController::class, 'approve'])->name('admin.leave.approve');
Route::get('admin/leave/reject/{id}', [AdminLeaveController::class, 'reject'])->name('admin.leave.reject');
Route::get('admin/leave/view/{id}', [AdminLeaveController::class, 'view'])->name('admin.leave.view');


Route::get('admin/leave', [AdminLeaveController::class, 'index'])->name('admin.leave.index');
Route::get('/admin/leave/search', [AdminLeaveController::class, 'search'])->name('admin.leave.search');

use App\Http\Controllers\Employee\LeaveController;

// Employee Leave Routes (without middleware)
Route::get('employee/leave', [LeaveController::class, 'index'])->name('employee.leave.index');
Route::post('employee/leave', [LeaveController::class, 'store'])->name('employee.leave.store');

Route::patch('/employee/leave/{id}/update-status/{status}', [LeaveController::class, 'updateStatus'])
    ->name('employee.leave.updateStatus');