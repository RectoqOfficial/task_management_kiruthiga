<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_title');
            $table->text('description');
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
    $table->string('assigned_to'); // Stores Employee Email
            $table->date('task_create_date');
            $table->date('task_start_date');
            $table->integer('no_of_days');
            $table->date('deadline');
            $table->enum('status', ['Pending', 'Started', 'Completed', 'Review'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
