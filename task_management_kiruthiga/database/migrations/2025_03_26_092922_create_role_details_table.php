<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('role_details', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->string('department');
            $table->unsignedBigInteger('department_id'); // Reference itself for department tracking
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('role_details');
    }
};
