<?php
// app/Models/Task.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_title', 'description', 'department', 'role', 'assigned_to', 'no_of_days', 'task_create_date', 'task_start_date', 'deadline',
    ];
     public function scoreDetails()
    {
        return $this->hasMany(ScoreDetail::class);
    }
}
