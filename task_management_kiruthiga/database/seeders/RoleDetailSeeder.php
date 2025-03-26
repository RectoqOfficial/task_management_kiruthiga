<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleDetail;

class RoleDetailSeeder extends Seeder
{
    public function run()
    {
        RoleDetail::insert([
            [
                'role' => 'Admin',
                'department' => 'IT',
                'department_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role' => 'Employee',
                'department' => 'HR',
                'department_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
