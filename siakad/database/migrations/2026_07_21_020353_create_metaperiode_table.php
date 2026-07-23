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
            $table->foreignId('periode_id')->constrained('periode')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('krs_mulai')->nullable();
            $table->timestamp('krs_selesai')->nullable();

            $table->timestamp('batal_tambah_mulai')->nullable();
            $table->timestamp('batal_tambah_selesai')->nullable();

            $table->timestamp('input_nilai_mulai')->nullable();
            $table->timestamp('input_nilai_selesai')->nullable();

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
