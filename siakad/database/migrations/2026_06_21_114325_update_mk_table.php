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
         Schema::table('mk', function (Blueprint $table) {
            $table->dropForeign(['kode_kurikulum']);
            $table->foreign('kode_kurikulum')->references('kode_kurikulum')->on('kurikulum')->onDelete('cascade')->onUpdate('cascade');

            
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('mk', function($table) {
             $table->dropForeign(['kode_kurikulum']);
             $table->foreign('kode_kurikulum')->references('kode_kurikulum')->on('kurikulum')->onDelete('cascade');
    });
    }
};
