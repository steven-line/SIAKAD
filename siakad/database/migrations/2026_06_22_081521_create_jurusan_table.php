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
        Schema::create('jurusan', function (Blueprint $table) {
            $table->string('kode_jurusan',3)->primary();
            $table->string('nama_jurusan',50)->nullable();
            $table->string('program_pendidikan',50);
  
            $table->string('sk_ban',50);
           
            $table->text('keterangan')->nullable();
            $table->string('fakultas',3);  
            $table->foreign('fakultas')->references('kode_fakultas')->on('fakultas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurusan');
    }
};
