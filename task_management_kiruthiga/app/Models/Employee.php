<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory;
protected $table = 'employees';
    protected $fillable = [
        'full_name', 'gender', 'date_of_joining', 'contact', 'email_id', 'password',
        'department_id', 'role_id', 'jobtype'
    ];

    protected $hidden = ['password']; // Hide password from JSON responses

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
      public function tasks()
    {
        return $this->hasMany(Task::class, 'employee_id');
    }
}
