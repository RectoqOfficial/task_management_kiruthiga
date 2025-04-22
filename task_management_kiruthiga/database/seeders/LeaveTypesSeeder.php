<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\LeaveType;

class LeaveTypesSeeder extends Seeder
{
    public function run()
    {
        LeaveType::create(['name' => 'Vacation']);
        LeaveType::create(['name' => 'Sick Leave']);
        LeaveType::create(['name' => 'Casual Leave']);
    }
}