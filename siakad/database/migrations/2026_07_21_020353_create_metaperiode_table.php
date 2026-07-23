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
            $table->timestamp('input_nilai_uts_mulai')->nullable();
            $table->timestamp('input_nilai_uts_selesai')->nullable();
            $table->timestamp('input_nilai_uas_mulai')->nullable();
            $table->timestamp('input_nilai_uas_selesai')->nullable();
            $table->timestamp('khs_mulai')->nullable();
            $table->timestamp('khs_selesai')->nullable();
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
