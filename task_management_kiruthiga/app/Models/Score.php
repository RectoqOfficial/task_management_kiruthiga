<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;
    
    protected $fillable = ['task_id', 'overdue_count', 'redo_count', 'score'];
 
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
}
