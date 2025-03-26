<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdminDetail; // Add this import
use App\Models\RoleDetail; // Import RoleDetail if needed
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

    
         AdminDetail::truncate();
          $this->call([
        RoleDetailSeeder::class,
        AdminDetailSeeder::class,
    ]);
    }
}
