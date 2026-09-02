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
        
            $table->integer('tinggi')->nullable()->default(0);
            $table->integer('berat')->nullable()->default(0);
            $table->string('alamat',100)->nullable()->default('');
            $table->string('kecamatan',20)->nullable()->default('');
            $table->string('kelurahan',50)->nullable()->default('');
            $table->string('kota',25)->nullable()->default('');
            $table->string('kodepos', 5)->nullable()->default('');
            $table->string('no_telp', 13)->nullable()->default('');
            $table->string('handphone', 13)->nullable()->default('');
            $table->string('hobby', 30)->nullable()->default('');
            $table->string('agama', 15)->nullable()->default('');
            $table->char('warganegara', 15)->nullable()->default('');
            $table->string('status_kawin', 15)->nullable()->default('');
            $table->string('gol_darah', 10)->nullable()->default('');
            $table->integer('anak_ke')->nullable()->default('0');
            $table->integer('jml_saudara')->nullable()->default('0');
            $table->integer('jml_saudara_tanggungan')->nullable()->default('0');
            $table->string('sumber_biaya', 25)->nullable()->default('');
            $table->string('jenis_rmh', 20)->nullable()->default('');
            $table->string('asal_smu', 50)->nullable()->default('');
            $table->string('lulus_smu', 4)->nullable()->default('');
            $table->string('transportasi', 25)->nullable()->default('');
            $table->string('nama_ayah', 50)->nullable()->default('');
            $table->string('alamat_ayah', 100)->nullable()->default('');
            $table->string('no_telp_ayah',13)->nullable()->default('');
            $table->string('kota_ayah', 25)->nullable()->default('');
            $table->string('kodepos_ayah', 5)->nullable()->default(''); 
            $table->string('handphone_ayah', 12)->nullable()->default('');
            $table->string('agama_ayah', 15)->nullable()->default('');
            $table->string('pekerjaan_ayah', 50)->nullable()->default('');
            $table->string('pendidikan_ayah', 25)->nullable()->default('');
            $table->string('warganegara_ayah', 20)->nullable()->default('');
            $table->string('nama_ibu', 50)->nullable()->default('');
            $table->string('alamat_ibu', 100)->nullable()->default('');
            $table->string('kota_ibu', 25)->nullable()->default('');
            $table->string('kodepos_ibu', 5)->nullable()->default('');
            $table->string('no_telp_ibu', 13)->nullable()->default('');
            $table->string('handphone_ibu', 12)->nullable()->default('');
            $table->string('agama_ibu', 15)->nullable()->default('');
            $table->string('pekerjaan_ibu', 50)->nullable()->default('');
            $table->string('pendidikan_ibu', 25)->nullable()->default('');
            $table->string('warganegara_ibu', 20)->nullable()->default('');
            $table->string('nama_wali', 50)->nullable()->default('');
            $table->string('alamat_wali', 100)->nullable()->default('');
            $table->string('kota_wali', 25)->nullable()->default('');
            $table->string('kodepos_wali', 5)->nullable()->default('');
            $table->string('no_telp_wali', 13)->nullable()->default('');
            $table->string('handphone_wali', 12)->nullable()->default('');
            $table->string('agama_wali', 15)->nullable()->default('');
            $table->string('pekerjaan_wali', 50)->nullable()->default('');
            $table->string('pendidikan_wali', 25)->nullable()->default('');
            $table->string('warganegara_wali', 20)->nullable()->default('');
            $table->char('special_need', 4)->nullable()->default('');
            $table->integer('kps')->nullable()->default(0);
            $table->string('status_pendidikan', 1)->nullable()->default('');
            $table->char('kebutuhan_ayah', 4)->nullable()->default('');
            $table->char('kebutuhan_ibu', 4)->nullable()->default('');
            $table->date('last_update')->nullable();
            $table->string('email', 100)->nullable()->default('');
            $table->enum('jenis_kelamin', ['P', 'L'])->default('P');
            $table->string('nisn', 25)->nullable();
             
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
