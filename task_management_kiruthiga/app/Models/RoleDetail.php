<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleDetail extends Model
{
    use HasFactory;

    protected $table = 'role_details';

    protected $fillable = ['role', 'department'];

    public function admins()
    {
        return $this->hasMany(AdminDetail::class, 'role_id');
    }
}
