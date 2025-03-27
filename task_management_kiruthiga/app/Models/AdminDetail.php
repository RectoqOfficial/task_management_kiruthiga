<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminDetail extends Authenticatable
{
    use HasFactory;

    protected $table = 'admin_details';

    protected $fillable = [
        'full_name', 'email', 'password', 'role_id', 'department_id'
    ];

    protected $hidden = [
        'password'
    ];

    public function role()
    {
        return $this->belongsTo(RoleDetail::class, 'role_id');
    }

    public function department()
    {
        return $this->belongsTo(RoleDetail::class, 'department_id');
    }
}
