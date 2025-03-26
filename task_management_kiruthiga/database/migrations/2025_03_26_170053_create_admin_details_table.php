<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('admin_details', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('role_id'); // Foreign key to role_details table
            $table->unsignedBigInteger('department_id'); // Foreign key to role_details table
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('role_id')->references('id')->on('role_details')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('role_details')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_details');
    }
};
