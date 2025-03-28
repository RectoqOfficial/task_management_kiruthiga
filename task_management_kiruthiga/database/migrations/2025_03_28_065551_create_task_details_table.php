<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('task_details', function (Blueprint $table) {
            $table->id();
            $table->string('task_title');
            $table->text('description');
            $table->unsignedBigInteger('role_id'); // Foreign Key from RoleDetail
            $table->unsignedBigInteger('department_id'); // Foreign Key from RoleDetail
            $table->unsignedBigInteger('assigned_to'); // Foreign Key from EmployeeDetail
            $table->date('deadline');
            $table->integer('no_of_days');
            $table->enum('status', ['Pending', 'In Progress', 'Completed'])->default('Pending');
            $table->text('remark')->nullable();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('role_id')->references('id')->on('role_details')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('role_details')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('employee_details')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('task_details');
    }
};
