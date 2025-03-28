<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskDetails extends Model
{
    use HasFactory;

    protected $table = 'task_details';

    protected $fillable = [
        'task_title',
        'description',
        'role_id',
        'department_id',
        'assigned_to',
        'deadline',
        'no_of_days',
        'status',
        'remark',
    ];

    // Relationship with RoleDetail
    public function role()
    {
        return $this->belongsTo(RoleDetail::class, 'role_id');
    }

    // Relationship with EmployeeDetail
    public function employee()
    {
        return $this->belongsTo(EmployeeDetail::class, 'assigned_to');
    }
}
