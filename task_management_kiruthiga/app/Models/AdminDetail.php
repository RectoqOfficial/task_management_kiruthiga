<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // ✅ Use this instead of Model
use Illuminate\Database\Eloquent\Model;

class AdminDetail extends Authenticatable // ✅ Extend Authenticatable instead of Model
{
    use HasFactory;  

    protected $table = 'admin_details';

    protected $fillable = ['full_name', 'email', 'password', 'role_id', 'department_id'];

    protected $hidden = ['password']; // ✅ Keep passwords hidden

    // Relationship with RoleDetail (Fetching role)
    public function role() {
        return $this->belongsTo(RoleDetail::class, 'role_id');
    }

    // Relationship with RoleDetail (Fetching department)
    public function department() {
        return $this->belongsTo(RoleDetail::class, 'department_id');
    }
}
