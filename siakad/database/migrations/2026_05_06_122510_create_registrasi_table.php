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
        Schema::create('registrasi', function (Blueprint $table) {
           $table->id('regkrs');
           $table->string('nrp', 8)->default('')->index();
           $table->string('kodemk', 8)->default('')->index();
           $table->string('periode', 9)->default('')->index();
           $table->string('status', 5)->default('');

           $table->string('sesi', 5)->default('')->index();
           $table->date('tanggal');
           $table->time('jam')->default('00:00:00');
           $table->integer('validasi')->default('0');

           $table->string('hari', 6)->default('');
           $table->time('mulaipukul')->default('00:00:00');
           $table->time('selesaipukul')->default('00:00:00');
           $table->string('ip_address', 100)->default('');
           $table->integer('sks')->default('0');
           $table->string('pataum', 1);

         
         
           $table->foreign('kodemk')
            ->references('kodemk')
            ->on('mk')
            ->onDelete('cascade');
          
            $table->index(['periode', 'sesi'], 'periode'); 
            $table->index(['kodemk', 'periode', 'sesi'], 'kodemk_2');




        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasi');
    }
};
