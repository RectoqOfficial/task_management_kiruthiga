<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminDetail;
use Illuminate\Support\Facades\Hash;

class AdminDetailSeeder extends Seeder
{
    public function run()
    {
        AdminDetail::insert([
            [
                'full_name' => 'kiruthi',
                'email' => 'kiruthigakeerthi1504@gmail.com',
                'password' => Hash::make('kiruthi15'), // Encrypt password
                'role_id' => 1, // Matches the ID in RoleDetailSeeder
                'department_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'full_name' => 'moni',
                'email' => 'monikamadhesh.mo.19@gmail.com',
                'password' => Hash::make('monika19'),
                'role_id' => 2, // Matches the ID in RoleDetailSeeder
                'department_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
