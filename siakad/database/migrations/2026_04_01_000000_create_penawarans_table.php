<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penawarans', function (Blueprint $table) {
            $table->bigIncrements('recno');

            $table->string('kodemk', 8);

            // 🔥 diperbaiki
            $table->integer('semester'); 

            $table->string('periode', 9);
            $table->string('dosen', 60);

            // 🔥 optional
            $table->string('sesi', 5)->nullable();
            $table->string('keterangan', 100)->nullable();

            $table->string('hari', 10);

            $table->time('mulaipukul');
            $table->time('selesaipukul');

            // 🔥 nanti diisi otomatis dari login
            $table->string('jurusan', 20);

            // 🔥 diperbaiki jadi angka
            $table->integer('pagu')->nullable();

            $table->string('pataum', 1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penawarans');
    }
};