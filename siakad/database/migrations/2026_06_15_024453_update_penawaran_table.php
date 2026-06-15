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
            $table->string('dosen', 15)->change(); 

            $table->foreign('dosen')->references('nim_dosen')->on('dosen')->onDelete('cascade');
             
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        //
            Schema::table('penawaran', function (Blueprint $table) {
                  $table->string('dosen', 60)->change(); 

        $table->dropForeign(['dosen']);
            });
    }
};
