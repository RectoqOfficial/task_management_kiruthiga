<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Score;
use App\Models\Department;
use App\Models\Role;
use App\Models\Employee;
use Illuminate\Support\Facades\Log; // Import for logging
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_title', 'description', 'department_id', 'role_id', 'assigned_to',
        'task_create_date', 'task_start_date', 'no_of_days', 'deadline', 'status', 'remarks'
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
        return $this->hasOne(Score::class, 'task_id', 'id');
    }
      public function calculateOverdue()
    {
        if ($this->status != 'Completed' && now()->greaterThan($this->deadline)) {
            $this->overdue_count += 1;
            $this->save();
        }
    }
 // Automatically create a score entry when a task is created
 protected static function booted()
    {
        static::created(function ($task) {
            try {
                Score::firstOrCreate(
                    ['task_id' => $task->id], // Avoid duplicate scores
                    [
                        'redo_count' => 0,
                        'overdue_count' => 0,
                        'score' => 100,
                    ]
                );
                Log::info("✅ Score created for Task ID: " . $task->id);
            } catch (\Exception $e) {
                Log::error("❌ Failed to create score for Task ID: " . $task->id . " | Error: " . $e->getMessage());
            }
        });
    }

}
