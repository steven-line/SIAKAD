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
        Schema::create('krs', function (Blueprint $table) {

            $table->id();

            // Relasi ke mahasiswa
            $table->string('nrp', 8);

            // Relasi ke mata kuliah
            $table->string('kode', 8);

            $table->char('bu', 1)->nullable();

            $table->decimal('ttt1', 5, 2)->nullable();
            $table->decimal('ttt2', 5, 2)->nullable();
            $table->decimal('ttt3', 5, 2)->nullable();

            $table->decimal('lain', 5, 2)->nullable();

            $table->decimal('uts', 5, 2)->nullable();
            $table->decimal('uas', 5, 2)->nullable();

            $table->string('na', 2)->nullable();

            $table->decimal('sks', 2, 0)->nullable();

            $table->string('periode', 8)->nullable();

            $table->char('kelas', 1);

            $table->boolean('survey')->default(false)
                  ->comment('0 = Belum, 1 = Sudah');

            // Foreign Key
            $table->foreign('nrp')
                ->references('nrp')
                ->on('mahasiswas')
                ->cascadeOnDelete();

            $table->foreign('kode')
                ->references('kodemk')
                ->on('mk')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('krs');
    }
};