<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class AdminDetail extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin_details';
    protected $fillable = ['full_name', 'email', 'password', 'role_id', 'department_id'];

    protected $hidden = [
        'password',
    ];
    protected $with = ['role'];
  protected $casts = [
        'password' => 'hashed', // Ensure password is hashed
    ];
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