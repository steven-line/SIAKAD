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
       Schema::table('registrasi', function (Blueprint $table) {
            $table->string('dosen', 15);

            $table->foreign('dosen')->references('nim_dosen')->on('dosen')->onDelete('cascade');
             
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        //
        Schema::table('registrasi', function (Blueprint $table) {
            $table->dropColumn('dosen');
            $table->dropForeign(['dosen']);
            });
    }
};
