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
        Schema::create('ips', function (Blueprint $table) {

            $table->string('nrp', 8);

            $table->integer('maksimal_sks')->default(0);
            $table->decimal('ips', 4, 3)->default(0.000);
            $table->integer('toleransi')->default(0);

            // Primary Key
            $table->primary('nrp');

            // Foreign Key ke tabel mahasiswas
            $table->foreign('nrp')
                ->references('nrp')
                ->on('mahasiswas')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ips');
    }
};