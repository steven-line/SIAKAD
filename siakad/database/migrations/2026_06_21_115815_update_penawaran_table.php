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
        Schema::table('penawaran', function (Blueprint $table) {
            // 1. Menghapus indeks biasa (BTREE) lama yang terdeteksi di phpMyAdmin
            $table->dropIndex('penawaran_dosen_foreign');
            $table->dropIndex('penawaran_jurusan_foreign');
            
            // 2. Membuat Foreign Key asli yang terhubung antar tabel
            $table->foreign('kodemk')->references('kodemk')->on('mk')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('dosen')->references('nim_dosen')->on('dosen')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('jurusan')->references('kode_jurusan')->on('jurusan')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penawaran', function (Blueprint $table) {
            // 1. Menghapus Foreign Key asli yang dibuat pada fungsi up() jika migrasi di-rollback
            $table->dropForeign(['kodemk']);
            $table->dropForeign(['dosen']);
            $table->dropForeign(['jurusan']);
            
            // 2. Mengembalikan struktur ke bentuk indeks biasa (BTREE) seperti semula
            $table->index(['dosen'], 'penawaran_dosen_foreign');
            $table->index(['jurusan'], 'penawaran_jurusan_foreign');
        });
    }
};