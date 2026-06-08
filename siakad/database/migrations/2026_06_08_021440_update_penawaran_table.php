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
        
    Schema::table('penawaran', function (Blueprint $table) {
            $table->boolean("MBKM")->default(false);
            
    });
          
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('penawaran', function($table) {
             $table->dropColumn('MBKM');
    });
    }
};
