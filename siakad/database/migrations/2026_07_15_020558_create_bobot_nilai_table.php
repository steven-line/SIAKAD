<?php

use App\Models\Penawaran;
use App\Models\Periode;
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
        Schema::create('bobotnilai', function (Blueprint $table) {

            $table->id();
		
            // Relasi ke mahasiswa
            $table->string('jenis');
            $table->string('kodemk', 8);
            $table->foreign('kodemk')->references('kodemk')->on('mk')->onUpdate('cascade')->onDelete('cascade');
	        $table->foreignIdFor(Periode::class)->cascadeOnUpdate()->cascadeOnDelete();
         
            // Relasi ke mata kuliah

            $table->decimal('ttt1', 5, 2)->default('20.00')->nullable();
            $table->decimal('ttt2', 5, 2)->default('20.00')->nullable();


            $table->decimal('lain', 5, 2)->default('20.00')->nullable();

            $table->decimal('uts', 5, 2)->default('20.00')->nullable();
            $table->decimal('uas', 5, 2)->default('20.00')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bobotnilai');
    }
};