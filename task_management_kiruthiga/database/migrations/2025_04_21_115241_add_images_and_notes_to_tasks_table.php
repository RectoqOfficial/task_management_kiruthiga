<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->text('images')->nullable()->after('status'); // For storing JSON array of image filenames
            $table->string('notes')->nullable()->after('images'); // For storing notes file name
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('images');
            $table->dropColumn('notes');
        });
    }
};
