<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDetail extends Model {
    use HasFactory;

    protected $table = 'employee_details';

    protected $fillable = [
        'fullname', 'gender', 'date_of_joining', 'contact', 
        'email_id', 'password', 'role_id', 'department', 
        'designation', 'jobtype'
    ];

    protected $hidden = ['password'];

    public function role() {
        return $this->belongsTo(RoleDetail::class, 'role_id','id');
    }
}
