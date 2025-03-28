<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_title');
            $table->text('description');
            $table->string('department');
            $table->string('role');
             $table->unsignedBigInteger('assigned_to');
            $table->integer('no_of_days');
            $table->date('task_create_date');
            $table->date('task_start_date');
            $table->date('deadline');
            $table->timestamps();
              $table->foreign('assigned_to')->references('id')->on('employee_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
