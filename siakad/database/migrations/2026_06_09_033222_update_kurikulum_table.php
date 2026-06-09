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
   Schema::table('kurikulum', function (Blueprint $table) {
            $table->text("deskripsi");
            $table->year("tahun_mulai_berlaku");
            $table->text("tahun_selesai_berlaku");
    });
          
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('kurikulum', function($table) {
             $table->dropColumn('deskripsi');
             $table->dropColumn('tahun_mulai_berlaku');
             $table->dropColumn('tahun_selesai_berlaku');
    });
    }
};
