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
          Schema::table('dosen', function (Blueprint $table) {
             $table->string('prodi', 15)->nullable();
             $table->foreign('prodi')->references('kode_prodi')->on('prodi')->onDelete('cascade');
            
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('dosen', function($table) {
             $table->dropForeign(['prodi']);
             $table->dropColumn('prodi');
    });
    }
};
