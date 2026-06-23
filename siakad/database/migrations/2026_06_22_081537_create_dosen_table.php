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
        Schema::create('dosen', function (Blueprint $table) {
            $table->string('nim_dosen', 15)->primary();
            $table->string('nip', 21)->nullable();
            $table->string('nama', 50);
	    $table->string('user_id',15)->nullable()->constrained()->unique();
            $table->foreign('user_id')->references('username')->on('users')->onDelete('cascade')->onUpdate('cascade');
	    $table->string('prodi', 15)->nullable();
            $table->foreign('prodi')->references('kode_prodi')->on('prodi')->onDelete('cascade')->onUpdate('cascade');
            $table->string("jabatan_struktural", 100);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
