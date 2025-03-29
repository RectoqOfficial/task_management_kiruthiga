<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('score_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained(tasks)->onDelete('cascade'); // Links to `tasks` table
            $table->integer('redo_count')->default(0);
            $table->boolean('overdue')->default(false);
            $table->integer('score')->default(100);
            $table->text('history')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('score_details');
    }
};
