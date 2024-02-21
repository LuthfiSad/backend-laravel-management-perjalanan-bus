<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rute_checkpoints', function (Blueprint $table) {
            $table->string('checkpoint_code');
            $table->unsignedBigInteger('rute_id');
            $table->unsignedBigInteger('terminal_id');
            $table->integer('waktu');
            $table->primary(['checkpoint_code', 'rute_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rute_checkpoints');
    }
};
