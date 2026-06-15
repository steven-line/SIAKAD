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
       Schema::table('mahasiswas', function (Blueprint $table) {
        $table->enum('status_blokir', [
            'BELUM_KRS',
            'MENUNGGU_VALIDASI',
            'DISETUJUI',
            'TERKUNCI'
        ])->default('BELUM_KRS')->change();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        //
            Schema::table('mahasiswas', function (Blueprint $table) {
                 $table->text('status_blokir')->change();
            });
    }
};
