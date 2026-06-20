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
            Schema::table('kurikulum', function($table) {
            
                $table->year('tahun_selesai_berlaku')->change();
            }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
         Schema::table('kurikulum', function($table) {
            
                $table->text('tahun_selesai_berlaku');
            }); 
    }
};
