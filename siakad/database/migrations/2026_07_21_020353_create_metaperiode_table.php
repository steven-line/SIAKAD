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
        Schema::create('metaperiode', function (Blueprint $table) {
            $table->id();

            $table->foreignId('periode_id')
                ->constrained('periode')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            /*
            |--------------------------------------------------------------------------
            | Periode Input Penawaran (Kaprodi)
            |--------------------------------------------------------------------------
            */
            $table->timestamp('input_penawaran_mulai')->nullable();
            $table->timestamp('input_penawaran_selesai')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Periode KRS
            |--------------------------------------------------------------------------
            */
            $table->timestamp('krs_mulai')->nullable();
            $table->timestamp('krs_selesai')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Periode Input Nilai UTS
            |--------------------------------------------------------------------------
            */
            $table->timestamp('input_nilai_uts_mulai')->nullable();
            $table->timestamp('input_nilai_uts_selesai')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Periode Input Nilai UAS
            |--------------------------------------------------------------------------
            */
            $table->timestamp('input_nilai_uas_mulai')->nullable();
            $table->timestamp('input_nilai_uas_selesai')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Periode Pengumuman Nilai Final
            |--------------------------------------------------------------------------
            */
            $table->timestamp('pengumuman_nilai_final_mulai')->nullable();
            $table->timestamp('pengumuman_nilai_final_selesai')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metaperiode');
    }
};