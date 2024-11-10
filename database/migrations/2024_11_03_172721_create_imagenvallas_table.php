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
        Schema::create('imagenvallas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vallas_id')->constrained('vallas')->onDelete('cascade');
            $table->string('image_path'); // Ruta o URL de la imagen
            $table->string('image_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagenvallas');
    }
};