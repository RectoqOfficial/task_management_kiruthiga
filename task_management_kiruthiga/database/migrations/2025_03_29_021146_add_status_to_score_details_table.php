<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('score_details', function (Blueprint $table) {
            $table->string('status')->default('Pending')->after('task_id'); // Adding status column
        });
    }

    public function down()
    {
        Schema::table('score_details', function (Blueprint $table) {
            $table->dropColumn('status'); // Removes status column on rollback
        });
    }
};
