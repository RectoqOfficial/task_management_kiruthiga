<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class Employee extends Authenticatable
{
    use HasFactory;

    protected $table = 'employees';
    protected $fillable = [
        'full_name', 'gender', 'date_of_joining', 'contact', 'email_id', 'password',
        'department_id', 'role_id', 'jobtype'
    ];

    protected $hidden = ['password']; // Hide password from JSON responses

    // Relationship to Department model
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Relationship to Role model
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relationship to Task model
    public function tasks()
    {
        return $this->hasMany(Task::class, 'employee_id');
    }

    // Relationship to LeaveRequest model
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

// Vacation Leave Balance Calculation
public function vacationLeaveBalance()
{
    $vacationLeaveUsed = $this->leaveRequests()
        ->whereHas('leaveType', function ($query) {
            $query->where('name', 'Vacation');
        })
        ->where('status', 'Approved')
        ->get()
        ->sum(function ($leaveRequest) {
            return Carbon::parse($leaveRequest->end_date)->diffInDays(Carbon::parse($leaveRequest->start_date)) + 1;
        });

    $totalVacationLeave = 20; // Assuming 20 vacation days per year
    return $totalVacationLeave - $vacationLeaveUsed; // Return the updated balance
}

// Sick Leave Balance Calculation
public function sickLeaveBalance()
{
    $sickLeaveUsed = $this->leaveRequests()
        ->whereHas('leaveType', function ($query) {
            $query->where('name', 'Sick');
        })
        ->where('status', 'Approved')
        ->get()
        ->sum(function ($leaveRequest) {
            return Carbon::parse($leaveRequest->end_date)->diffInDays(Carbon::parse($leaveRequest->start_date)) + 1;
        });

    $totalSickLeave = 10; // Assuming 10 sick days per year
    return $totalSickLeave - $sickLeaveUsed; // Return the updated balance
}

}
