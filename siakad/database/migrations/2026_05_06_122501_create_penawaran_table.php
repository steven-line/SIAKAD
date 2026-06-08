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
            $table->char('semester',2)->default('0');
            $table->string('periode',9)->default('');
            $table->string('dosen',60)->default('');

            $table->string('sesi',5)->default('')->index();
            $table->string('keterangan',100)->default('');
            $table->string('hari',6)->default('');
            $table->time('mulaipukul');
            
            $table->time('selesaipukul');
            $table->string('jurusan',3)->default('');
            $table->string('pagu',3)->default('0');
            $table->string('pataum',1);
            
            $table->foreign('kodemk')->references('kodemk')->on('mk')
                  ->onDelete('cascade');

            $table->foreign('jurusan')->references('kode_jurusan')->on('jurusan')
                  ->onDelete('cascade');

            // Menambahkan Composite Index sesuai kebutuhan SQL Dump Anda (untuk mempercepat filter KRS)
            $table->index(['semester', 'jurusan'], 'idx_sem_jur');
            $table->index(['kodemk', 'jurusan'], 'idx_mk_jur');
            $table->index(['recno', 'kodemk', 'semester', 'periode', 'sesi', 'jurusan'], 'idx_recno_full');
            
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
