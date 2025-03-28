<?php
// app/Models/ScoreDetail.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id', 'redo_count', 'overdue', 'score', 'history'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // Calculate the score based on the redo count and overdue status
    public static function calculateScore($redoCount, $isOverdue)
    {
        $score = 100;

        if ($isOverdue) {
            $score = 80;
        } else {
            $score -= (10 * $redoCount);
            $score = max(0, $score); // Ensure score does not go below 0
        }

        return $score;
    }
}
