<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('employee_details', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('date_of_joining');
            $table->string('contact');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('department');
            $table->string('designation');
            $table->enum('jobtype', ['onsite', 'remote']);
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_details');
    }
};
