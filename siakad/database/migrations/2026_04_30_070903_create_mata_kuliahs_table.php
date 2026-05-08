<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mata_kuliahs', function (Blueprint $table) {
            $table->string('kodemk', 8)->primary(); // 🔥 primary key

            $table->string('nama', 50);
            $table->char('sks', 3);
            $table->char('nm_jenj_didik', 2);
            $table->char('kode_prodi_dikti', 5);

            $table->char('prasyaratsks', 3)->nullable();

            // 🔥 prasyarat 1 - 10
            $table->string('prasyarat1', 8)->nullable();
            $table->string('prasyarat2', 8)->nullable();
            $table->string('prasyarat3', 8)->nullable();
            $table->string('prasyarat4', 8)->nullable();
            $table->string('prasyarat5', 8)->nullable();
            $table->string('prasyarat6', 8)->nullable();
            $table->string('prasyarat7', 8)->nullable();
            $table->string('prasyarat8', 8)->nullable();
            $table->string('prasyarat9', 8)->nullable();
            $table->string('prasyarat10', 8)->nullable();

            $table->char('prasyaratgrade', 1)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mata_kuliahs');
    }
};
