```php
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
        Schema::create('metaperiode', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | PERIODE
            |--------------------------------------------------------------------------
            */
            $table->foreignId('periode_id')
                ->constrained('periode')
                ->onDelete('cascade')
                ->onUpdate('cascade');


            /*
            |--------------------------------------------------------------------------
            | PERIODE INPUT PENAWARAN (KAPRODI)
            |--------------------------------------------------------------------------
            */
            $table->timestamp('input_penawaran_mulai')
                ->nullable();

            $table->timestamp('input_penawaran_selesai')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | PERIODE KRS
            |--------------------------------------------------------------------------
            */
            $table->timestamp('krs_mulai')
                ->nullable();

            $table->timestamp('krs_selesai')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | PERIODE INPUT NILAI UTS
            |--------------------------------------------------------------------------
            */
            $table->timestamp('input_nilai_uts_mulai')
                ->nullable();

            $table->timestamp('input_nilai_uts_selesai')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | PERIODE INPUT NILAI UAS
            |--------------------------------------------------------------------------
            */
            $table->timestamp('input_nilai_uas_mulai')
                ->nullable();

            $table->timestamp('input_nilai_uas_selesai')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | INPUT NILAI MATA KULIAH KHUSUS
            |--------------------------------------------------------------------------
            |
            | Menyimpan daftar kodemk yang diperbolehkan untuk input nilai
            | di luar periode UTS/UAS.
            |
            | Contoh:
            |
            | {
            |     "TA001": true,
            |     "KKN01": false,
            |     "MAG01": true
            | }
            |
            | true  = boleh input nilai
            | false = tidak boleh input nilai
            |
            */
            $table->json('mk_khusus')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | PERIODE PENGUMUMAN NILAI FINAL
            |--------------------------------------------------------------------------
            */
            $table->timestamp('pengumuman_nilai_final_mulai')
                ->nullable();

            $table->timestamp('pengumuman_nilai_final_selesai')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | TIMESTAMPS
            |--------------------------------------------------------------------------
            */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metaperiode');
    }
};
