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
        Schema::create('mk', function (Blueprint $table) {
            $table->string('kodemk', 8)->primary();
            $table->string('nama',50)->default('');
            $table->char('sks',3)->default('0');
            $table->char('nm_jenj_didik', 2);
            $table->char('kode_prodi_dikti',5);
            $table->string('prasyaratsks', 3)->default('0');

            $table->string('prasyarat1',8)->default('');
            $table->string('prasyarat2',8)->default('');
            $table->string('prasyarat3',8)->default('');
            $table->string('prasyarat4',8)->default('');
            $table->string('prasyarat5',8)->default('');
            $table->string('prasyarat6',8)->default('');
            $table->string('prasyarat7',8)->default('');
            $table->string('prasyarat8',8)->default('');
            $table->string('prasyarat9',8)->default('');
            $table->string('prasyarat10',8)->default('');
            $table->char('prasyaratgrade',1)->default('');
     
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mk');
    }
};
