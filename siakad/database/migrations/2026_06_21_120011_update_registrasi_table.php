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
        Schema::table('registrasi', function (Blueprint $table) {
            $table->dropForeign(['nrp']);
            $table->dropForeign(['kodemk']);
            $table->dropForeign(['dosen']);
            $table->foreign('nrp')->references('nrp')->on('mahasiswas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kodemk')->references('kodemk')->on('mk')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('dosen')->references('nim_dosen')->on('dosen')->onDelete('cascade')->onUpdate('cascade');
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrasi', function (Blueprint $table) {
             $table->dropForeign(['nrp']);
             $table->foreign('nrp')->references('nrp')->on('mahasiswas')->onDelete('cascade');
             $table->dropForeign(['kodemk']);
             $table->foreign('kodemk')->references('kodemk')->on('mk')->onDelete('cascade');
             $table->dropForeign(['dosen']);
             $table->foreign('dosen')->references('nim_dosen')->on('dosen')->onDelete('cascade');
        });
    }
};
