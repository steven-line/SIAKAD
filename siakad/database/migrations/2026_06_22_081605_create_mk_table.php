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
        Schema::create('mk', function (Blueprint $table) {

            // =====================================================
            // IDENTITAS MATA KULIAH
            // =====================================================

            $table->string('kodemk', 8)->primary();

            $table->string('nama', 50)->default('');

            $table->char('sks', 3)->default('0');

            $table->char('nm_jenj_didik', 2);


            // =====================================================
            // PERIODE INPUT NILAI
            // =====================================================
            //
            // normal  = mengikuti periode input nilai UTS/UAS
            // khusus  = tidak mengikuti periode input nilai UTS/UAS
            //
            // Catatan:
            // Field ini digunakan untuk menentukan apakah dosen
            // boleh menginput nilai UTS/UAS berdasarkan periode
            // MetaPeriode atau tidak.
            //

            $table->enum('periode_input', [
                'normal',
                'khusus',
            ])->default('normal');


            // =====================================================
            // JENIS MATA KULIAH
            // =====================================================
            //
            // mk_fakultas = PJMK diatur oleh Admin
            // mk_umum     = PJMK diatur oleh Admin
            // mk_prodi    = PJMK diatur oleh Kaprodi
            // mk_khusus   = PJMK diatur oleh Kaprodi
            //
            // MK khusus contoh:
            // - Tugas Akhir
            // - Magang
            // - Publikasi
            // - Proposal TA
            //

            $table->enum('jenis_mk', [
                'mk_fakultas',
                'mk_umum',
                'mk_prodi',
                'mk_khusus',
            ])->default('mk_prodi');


            // =====================================================
            // PRASYARAT
            // =====================================================

            $table->string('prasyaratsks', 3)->default('0');

            $table->string('prasyarat1', 8)->default('');
            $table->string('prasyarat2', 8)->default('');
            $table->string('prasyarat3', 8)->default('');
            $table->string('prasyarat4', 8)->default('');
            $table->string('prasyarat5', 8)->default('');
            $table->string('prasyarat6', 8)->default('');
            $table->string('prasyarat7', 8)->default('');
            $table->string('prasyarat8', 8)->default('');
            $table->string('prasyarat9', 8)->default('');
            $table->string('prasyarat10', 8)->default('');

            $table->char('prasyaratgrade', 1)->default('');


            // =====================================================
            // KURIKULUM
            // =====================================================

            $table->string('kode_kurikulum', 15);

            $table->foreign('kode_kurikulum')
                ->references('kode_kurikulum')
                ->on('kurikulum')
                ->onDelete('cascade')
                ->onUpdate('cascade');


            // =====================================================
            // STATUS
            // =====================================================

            $table->boolean('aktif')->default(false);

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mk');
    }
};