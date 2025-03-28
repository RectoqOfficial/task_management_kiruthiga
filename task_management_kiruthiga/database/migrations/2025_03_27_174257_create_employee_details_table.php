<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('employee_details', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->date('date_of_joining');
            $table->string('contact');
            $table->string('email_id')->unique();
            $table->string('password');
            $table->unsignedBigInteger('role_id');
            $table->string('department');
            $table->string('designation');
            $table->enum('jobtype', ['Full-time', 'Part-time', 'Intern']);
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('role_details')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('employee_details');
    }
};
