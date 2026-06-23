<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penawaran', function (Blueprint $table) {

            // hapus FK lama jika ada
            try {
                $table->dropForeign(['dosen']);
            } catch (\Exception $e) {}

            try {
                $table->dropForeign(['jurusan']);
            } catch (\Exception $e) {}

            try {
                $table->dropForeign(['kodemk']);
            } catch (\Exception $e) {}

            // buat ulang FK
            $table->foreign('kodemk')
                ->references('kodemk')
                ->on('mk')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('dosen')
                ->references('nim_dosen')
                ->on('dosen')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('jurusan')
                ->references('kode_jurusan')
                ->on('jurusan')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::table('penawaran', function (Blueprint $table) {

            $table->dropForeign(['kodemk']);
            $table->dropForeign(['dosen']);
            $table->dropForeign(['jurusan']);
        });
    }
};