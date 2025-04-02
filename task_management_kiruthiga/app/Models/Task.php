<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_title', 'description', 'department_id', 'role_id', 'assigned_to',
        'task_create_date', 'task_start_date', 'no_of_days', 'deadline', 'status'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
       public function employee()
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }

    public function score()
{
    return $this->hasOne(Score::class, 'task_id');
}

}
