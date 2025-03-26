<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminDetail extends Model
{
    use HasFactory;

    protected $table = 'admin_details';
    protected $fillable = ['full_name', 'email', 'password', 'role_id', 'department_id'];

    // Admin belongs to a role
    public function role()
    {
        return $this->belongsTo(RoleDetail::class, 'role_id');
    }

    // Admin belongs to a department
    public function department()
    {
        return $this->belongsTo(RoleDetail::class, 'department_id');
    }
}
