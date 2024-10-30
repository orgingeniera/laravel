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
        Schema::table('declaracionesanul_images', function (Blueprint $table) {
            $table->string('image_url')->nullable()->after('image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('declaracionesanul_images', function (Blueprint $table) {
            $table->dropColumn('image_url'); // Elimina el campo si se revierte la migración
        });
    }
};
