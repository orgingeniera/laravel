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
        Schema::create('vallas', function (Blueprint $table) {
            $table->id();
            $table->string('opcion');
            $table->string('n_registro')->unique();
            $table->date('fecha_instalacion');
            $table->string('lugar_instalacion');
            $table->string('donde_instalo');
            $table->decimal('base_gravable', 15, 0);
            $table->decimal('impuesto_pagar', 15, 0);
            $table->unsignedBigInteger('contribuyente_id'); // Llave foránea

            // Definir la relación de la llave foránea con la tabla contribuyentes
            $table->foreign('contribuyente_id')->references('id')->on('contribuyentes')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vallas');
    }
};
