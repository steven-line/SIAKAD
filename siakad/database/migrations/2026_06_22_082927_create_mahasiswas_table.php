<?php

use App\Models\Dosen;
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
        Schema::create('mahasiswas', function (Blueprint $table) {

            $table->string('nrp')->primary();
            $table->string('nama');
            $table->string('dosen_wali',15);
	    $table->string('prodi', 15)->nullable();
            $table->foreign('prodi')->references('kode_prodi')->on('prodi')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('nrp')->references('username')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status_blokir', [
            'BELUM_KRS',
            'MENUNGGU_VALIDASI',
            'DISETUJUI',
            'TERKUNCI'
             ])->default('BELUM_KRS')->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};