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
         Schema::table('prodi', function (Blueprint $table) {
                   $table->string('kode_fakultas', 15);
                   $table->foreign('kode_fakultas')->references('kode_fakultas')->on('fakultas')->onDelete('cascade');

         
            
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('prodi', function($table) {
             $table->dropForeign(['kode_fakultas']);
             $table->dropColumn('kode_fakultas');
    });
    }
};
