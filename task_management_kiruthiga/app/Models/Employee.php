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
public function approvedLeaveDays($type)
{
    return $this->leaveRequests()
        ->whereHas('leaveType', function ($query) use ($type) {
            $query->where('name', $type);
        })
        ->where('status', 'Approved')
        ->get()
        ->sum(function ($leave) {
            return Carbon::parse($leave->start_date)->diffInDays(Carbon::parse($leave->end_date)) + 1;
        });
}

public function vacationLeaveBalance()
{
    $totalAllowed = 20; // Or fetch from config or DB if dynamic
    return $totalAllowed - $this->approvedLeaveDays('Vacation');
}

public function sickLeaveBalance()
{
    $total = 10;
    return max(0, $total - $this->approvedLeaveDays('Sick Leave'));
}
public function casualLeaveBalance()
{
    $total = 5; // You can customize this
    return max(0, $total - $this->approvedLeaveDays('Casual Leave'));
}


}
