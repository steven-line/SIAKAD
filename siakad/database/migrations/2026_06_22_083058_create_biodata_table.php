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
        Schema::create('biodata', function (Blueprint $table) {
	    $table->id();
            $table->string('nrp',8);
	   $table->foreign('nrp')->references('nrp')->on('mahasiswas')->onDelete('cascade')->onUpdate('cascade');
           
            $table->string('nama', 50)->default('');
            $table->char('nik',16);
            $table->string('tempat_lahir', 25)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->char('sex', 1)->default('');
            $table->integer('tinggi')->default(0);
            $table->integer('berat')->default(0);
            $table->string('alamat',100)->default('');
            $table->string('kecamatan',20);
            $table->string('kelurahan',50);
            $table->string('kota',25)->default('');
            $table->string('kodepos', 5)->default('');
            $table->string('no_telp', 13)->default('');
            $table->string('handphone', 13)->default('');
            $table->string('hobby', 30);
            $table->string('agama', 15)->default('');
            $table->char('warganegara', 15)->default('');
            $table->string('status_kawin', 15)->default('');
            $table->string('gol_darah', 10)->default('');
            $table->integer('anak_ke')->default('0');
            $table->integer('jml_saudara')->default('0');
            $table->integer('jml_saudara_tanggungan')->default('0');
            $table->string('sumber_biaya', 25)->default('');
            $table->string('jenis_rmh', 20)->default('');
            $table->string('asal_smu', 50)->default('');
            $table->string('lulus_smu', 4)->default('');
            $table->string('transportasi', 25)->default('');
            $table->string('nama_ayah', 50)->default('');
            $table->string('alamat_ayah', 100)->default('');
            $table->string('no_telp_ayah',13)->default('');
            $table->string('kota_ayah', 25)->default('');
            $table->string('kodepos_ayah', 5)->default(''); 
            $table->string('handphone_ayah', 12)->default('');
            $table->string('agama_ayah', 15)->default('');
            $table->string('pekerjaan_ayah', 50)->default('');
            $table->string('pendidikan_ayah', 25)->default('');
            $table->string('warganegara_ayah', 20)->default('');
            $table->string('nama_ibu', 50)->default('');
            $table->string('alamat_ibu', 100)->default('');
            $table->string('kota_ibu', 25)->default('');
            $table->string('kodepos_ibu', 5)->default('');
            $table->string('no_telp_ibu', 13)->default('');
            $table->string('handphone_ibu', 12)->default('');
            $table->string('agama_ibu', 15)->default('');
            $table->string('pekerjaan_ibu', 50)->default('');
            $table->string('pendidikan_ibu', 25)->default('');
            $table->string('warganegara_ibu', 20)->default('');
            $table->string('nama_wali', 50)->default('');
            $table->string('alamat_wali', 100)->default('');
            $table->string('kota_wali', 25)->default('');
            $table->string('kodepos_wali', 5)->default('');
            $table->string('no_telp_wali', 13)->default('');
            $table->string('handphone_wali', 12)->default('');
            $table->string('agama_wali', 15)->default('');
            $table->string('pekerjaan_wali', 50)->default('');
            $table->string('pendidikan_wali', 25)->default('');
            $table->string('warganegara_wali', 20)->default('');
            $table->char('special_need', 4);
            $table->integer('kps');
            $table->string('status_pendidikan', 1);
            $table->char('kebutuhan_ayah', 4);
            $table->char('kebutuhan_ibu', 4);
            $table->date('last_update');
            $table->string('email', 100);
            $table->string('jenis_kelamin', 12);
            $table->string('nisn', 25);
             
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biodata');
    }
};
