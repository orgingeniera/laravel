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
        Schema::table('declaracionesanul', function (Blueprint $table) {
            $table->decimal('total_ingresos_nacionales', 15, 0)->change();
            $table->decimal('menos_ingresos_fuera_municipio', 15, 0)->change();
            $table->decimal('total_ingresos_municipio', 15, 0)->change();
            $table->decimal('menos_ingresos_rebajas', 15, 0)->change();
            $table->decimal('menos_ingresos_exportaciones', 15, 0)->change();
            $table->decimal('menos_ingresos_venta_activos', 15, 0)->change();
            $table->decimal('menos_ingresos_no_gravados', 15, 0)->change();
            $table->decimal('menos_ingresos_exentos', 15, 0)->change();
            $table->decimal('total_ingresos_gravables', 15, 0)->change();
            $table->decimal('total_impuesto', 15, 0)->change();
            $table->decimal('capacidad_kw', 15, 0)->change();
            $table->decimal('impuesto_ley_56', 15, 0)->change();
            $table->decimal('total_industria_comercio', 15, 0)->change();
            $table->decimal('impuesto_avisos_tableros', 15, 0)->change();
            $table->decimal('pago_unidades_adicionales', 15, 0)->change();
            $table->decimal('sobretasa_bomberil', 15, 0)->change();
            $table->decimal('sobretasa_seguridad', 15, 0)->change();
            $table->decimal('total_impuesto_cargo', 15, 0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('declaracionesanul', function (Blueprint $table) {
            $table->decimal('total_ingresos_nacionales', 15, 2)->change();
            $table->decimal('menos_ingresos_fuera_municipio', 15, 2)->change();
            $table->decimal('total_ingresos_municipio', 15, 2)->change();
            $table->decimal('menos_ingresos_rebajas', 15, 2)->change();
            $table->decimal('menos_ingresos_exportaciones', 15, 2)->change();
            $table->decimal('menos_ingresos_venta_activos', 15, 2)->change();
            $table->decimal('menos_ingresos_no_gravados', 15, 2)->change();
            $table->decimal('menos_ingresos_exentos', 15, 2)->change();
            $table->decimal('total_ingresos_gravables', 15, 2)->change();
            $table->decimal('total_impuesto', 15, 2)->change();
            $table->decimal('capacidad_kw', 15, 2)->change();
            $table->decimal('impuesto_ley_56', 15, 2)->change();
            $table->decimal('total_industria_comercio', 15, 2)->change();
            $table->decimal('impuesto_avisos_tableros', 15, 2)->change();
            $table->decimal('pago_unidades_adicionales', 15, 2)->change();
            $table->decimal('sobretasa_bomberil', 15, 2)->change();
            $table->decimal('sobretasa_seguridad', 15, 2)->change();
            $table->decimal('total_impuesto_cargo', 15, 2)->change();
        });
    }
};
