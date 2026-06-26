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
        Schema::create('kurikulum', function (Blueprint $table) {
            $table->string('kode_kurikulum', 15)->primary();
            $table->string('nama_kurikulum',50);
            $table->boolean("aktif")->default(false);
            $table->text("deskripsi");
            $table->year("tahun_mulai_berlaku");
            $table->year("tahun_selesai_berlaku");
            $table->string('kode_prodi', 15);
            $table->foreign('kode_prodi')->references('kode_prodi')->on('prodi')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurikulum');
    }
};
