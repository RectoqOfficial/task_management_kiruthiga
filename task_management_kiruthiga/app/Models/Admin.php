<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'password',
        'role_id',
        'department_id',
    ];

    protected $hidden = ['password'];

     public function role()
    {
        return $this->belongsTo(Role::class, 'role_id'); // Ensure role_id is used properly
    }

     public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
