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
        Schema::create('declaracionesanul_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('declaracionesanul_id')->constrained('declaracionesanul')->onDelete('cascade');
            $table->string('image_path'); // Ruta o URL de la imagen
            $table->string('image_name')->nullable(); // Nombre de la imagen (opcional)
            $table->timestamps();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('declaracionesanul_images');
    }
};
