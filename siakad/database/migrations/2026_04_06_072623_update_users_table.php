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
        //
        Schema::table('users', function (Blueprint $table) {
            $table->integer('validasi')->nullable()->change();
            $table->integer('aksesnilai')->nullable()->change();
            $table->string('pataum', 1)->nullable()->change();
            $table->integer('aktif')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('úsers', function(Blueprint $table) {
            $table->integer('validasi')->nullable(false)->change();
            $table->integer('aksesnilai')->nullable(false)->change();
            $table->string('pataum', 1)->nullable(false)->change();
            $table->integer('aktif')->nullable(false)->change();

        });
    }
};
