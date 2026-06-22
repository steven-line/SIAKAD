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
	    $table->unsignedBigInteger('registrasi_id');
            $table->foreign('registrasi_id')->references('regkrs')->on('registrasi')->onDelete('cascade')->onUpdate('cascade');

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
		 

            $table->char('kelas', 1);

            $table->boolean('survey')->default(false)
                  ->comment('0 = Belum, 1 = Sudah');


            $table->foreign('kode')
                ->references('kodemk')
                ->on('mk')
                ->onDelete('cascade')
		->onUpdate('cascade');
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