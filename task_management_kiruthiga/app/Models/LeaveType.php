<?php
// app/Models/LeaveType.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
