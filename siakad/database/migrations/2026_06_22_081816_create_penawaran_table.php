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
        Schema::create('penawaran', function (Blueprint $table) {
            $table->id('recno');
            $table->string('kodemk',8)->default('');
            $table->foreignId('semester_id')->constrained('semester')->onDelete('cascade')->onUpdate('cascade');

            $table->string('dosen', 15); 
            $table->foreign('dosen')->references('nim_dosen')->on('dosen')->onDelete('cascade')->onUpdate('cascade');
            $table->string('sesi',5)->default('')->index();
            $table->string('keterangan',100)->default('');
            $table->string('hari',6)->default('');
            $table->time('mulaipukul');
            $table->time('selesaipukul');
            $table->string('prodi',15)->default('');
            $table->string('pagu',3)->default('0');
            $table->enum('pataum', ['P', 'M'])->default('P');
            $table->foreign('kodemk')->references('kodemk')->on('mk')
                  ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('prodi')->references('kode_prodi')->on('prodi')
                  ->onDelete('cascade')->onUpdate('cascade');
            $table->boolean("MBKM")->default(false);

            // Menambahkan Composite Index sesuai kebutuhan SQL Dump Anda (untuk mempercepat filter KRS)
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penawaran');
    }
};
