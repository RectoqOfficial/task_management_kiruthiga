<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminDetail;
use Illuminate\Support\Facades\Hash;

class AdminDetailSeeder extends Seeder {
    public function run() {
        AdminDetail::create([
            'full_name' => 'Super Admin',
            'email' => 'kiruthigakeerthi1504@gmail.com',
            'password' => Hash::make('kiruthi15'),
            'role_id' => 1,
            'department_id' => 1,
        ]);
    }
}