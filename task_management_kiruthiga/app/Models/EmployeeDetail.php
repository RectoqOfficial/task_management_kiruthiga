<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class EmployeeDetail extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'gender',
        'date_of_joining',
        'contact',
        'email',
        'password',
        'department',
        'designation',
        'jobtype',
        'role_id',
    ];

    protected $hidden = [
        'password',
    ];

    // Relationship with Role Model
    public function role()
    {
        return $this->belongsTo(RoleDetail::class);
    }
}
