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
        Schema::table('vallas', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('impuesto_pagar'); // Ruta de la imagen en el servidor
            $table->string('image_url')->nullable()->after('image_path'); // URL completa de la imagen
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vallas', function (Blueprint $table) {
            $table->dropColumn('image_path');
            $table->dropColumn('image_url');
        });
    }
};
