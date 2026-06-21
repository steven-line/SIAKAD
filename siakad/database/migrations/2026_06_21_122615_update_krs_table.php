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
        Schema::table('krs', function (Blueprint $table) {
            $table->dropForeign(['nrp']);
            $table->dropForeign(['kode']);

            $table->foreign('nrp')
                ->references('nrp')
                ->on('mahasiswas')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('kode')
                ->references('kodemk')
                ->on('mk')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
          Schema::table('krs', function (Blueprint $table) {
            $table->dropForeign(['nrp']);
            $table->dropForeign(['kode']);
            $table->foreign('nrp')
                ->references('nrp')
                ->on('mahasiswas')
                ->onDelete('cascade');
                

            $table->foreign('kode')
                ->references('kodemk')
                ->on('mk')
                ->onDelete('cascade');
                
                
        });
    }
};