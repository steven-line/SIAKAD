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
        
       Schema::table('dosen', function (Blueprint $table) {
            $table->string('user_id',15)->nullable()->constrained()->unique();
            $table->foreign('user_id')->references('username')->on('users')->onDelete('cascade');
            
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dosen', function($table) {
             $table->dropForeign(['user_id']);
             $table->dropColumn('user_id');
    });
    }
};
