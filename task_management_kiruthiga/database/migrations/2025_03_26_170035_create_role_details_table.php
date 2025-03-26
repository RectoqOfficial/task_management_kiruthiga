<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('role_details', function (Blueprint $table) {
            $table->id();
            $table->string('role'); // Role Name (e.g., Admin, Employee)
            $table->string('department'); // Department Name
            $table->unsignedBigInteger('department_id'); // Foreign key for department
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('role_details');
    }
};
