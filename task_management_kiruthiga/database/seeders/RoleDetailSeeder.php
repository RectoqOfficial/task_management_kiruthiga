<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleDetail;

class RoleDetailSeeder extends Seeder {
    public function run() {
        RoleDetail::insert([
            ['role' => 'Admin', 'department' => 'Management', 'department_id' => 1],
            ['role' => 'Employee', 'department' => 'IT', 'department_id' => 2],
        ]);
    }
}
