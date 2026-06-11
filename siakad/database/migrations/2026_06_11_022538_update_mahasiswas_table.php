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
        //

     Schema::table('mahasiswas', function (Blueprint $table) {
           $table->dropColumn('nama');
           $table->string('prodi', 15)->nullable();
           $table->foreign('prodi')->references('kode_prodi')->on('prodi')->onDelete('cascade');
           $table->foreign('nrp')->references('username')->on('users')->onDelete('cascade');
             
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    Schema::table('mahasiswas', function($table) {
             $table->dropForeign(['prodi']);
            $table->dropColumn('prodi');
             $table->string('nama');
    });
        
    }
};
