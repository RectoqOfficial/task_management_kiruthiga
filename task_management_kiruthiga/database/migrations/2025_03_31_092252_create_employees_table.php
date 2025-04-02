<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->date('date_of_joining');
            $table->string('contact');
            $table->string('email_id')->unique();
            $table->string('password'); // Stored but not displayed
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->enum('jobtype', ['Full-Time', 'Part-Time', 'Contract']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
 