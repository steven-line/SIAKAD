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
        Schema::create('pjmk', function (Blueprint $table) {
  
            $table->string('nim_dosen', 15);
            $table->string('kodemk', 8)->primary();
            $table->foreign('nim_dosen')->references('nim_dosen')->on('dosen')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kodemk')->references('kodemk')->on('mk')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pjmk');
    }
};
