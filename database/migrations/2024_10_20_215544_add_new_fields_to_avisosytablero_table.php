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
        Schema::table('avisosytablero', function (Blueprint $table) {
            $table->string('concepto')->nullable();   // Campo de texto para el concepto
            $table->bigInteger('ica')->nullable();    // BIGINT para 'ica'
            $table->bigInteger('navisosytableros')->nullable();  // BIGINT para 'avisosytableros'
            $table->bigInteger('autobimestral')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('avisosytablero', function (Blueprint $table) {
            $table->dropColumn('concepto');
            $table->dropColumn('ica');
            $table->dropColumn('avisosytableros');
            $table->dropColumn('autobimestral');
        });
    }
};
