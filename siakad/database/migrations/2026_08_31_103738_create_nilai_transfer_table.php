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
        Schema::create('nilai_transfer', function (Blueprint $table) {
            $table->id();
            $table->string('nrp', 8);
            $table->foreign('nrp')->references('nrp')->on('mahasiswas')->onDelete('cascade')->onUpdate('cascade');
            $table->string('kodemk', 8);
            $table->foreign('kodemk')->references('kodemk')->on('mk')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('sks')->default(0);
            $table->string('na', 2);
         
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_transfer');
    }
};
