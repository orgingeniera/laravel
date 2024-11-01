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
        Schema::create('declaracionesmensuales', function (Blueprint $table) {
            $table->id();
            $table->string('n_declaracion', 50)->nullable();
            $table->year('vigencia')->nullable();
            $table->string('periodo')->nullable(); // Periodo como string
            $table->date('fecha_declaracion')->nullable();
            $table->string('nit_contribuyente', 20)->nullable();
            $table->string('razon_social', 255)->nullable();
            $table->string('regimen', 50)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->string('ciudad', 100)->nullable();
            $table->string('correo_electronico', 100)->nullable();
            $table->decimal('total_ingresos_brutos', 15, 0)->nullable(); // Total Ingresos Brutos Ordinarios Y Extraordinarios
            $table->decimal('menos_devoluciones_subsidios', 15, 0)->nullable(); // Menos Devoluciones y Subsidios
            $table->decimal('menos_ingresos_fuera_municipio', 15, 0)->nullable(); // Menos Ingresos Obtenidos Fuera De Este Municipio
            $table->decimal('menos_ventas_activos_exportacion', 15, 0)->nullable(); // Menos Ventas De Activos Fijos Y Ventas De Exportacion
            $table->decimal('menos_ingresos_exentos_no_sujetos', 15, 0)->nullable(); // Menos Ingresos Por Actividades Exentas Y No Sujetas
            $table->decimal('total_ingresos_gravables', 15, 0)->nullable(); // Total Ingresos Gravables Autoretencion
            $table->decimal('autoretencion_impuesto_industria_comercio', 15, 0)->nullable(); // Autoretención De Impuesto De Industria Y Comercio
            $table->decimal('mas_autoretenciones_impuestos_avisos_tableros', 15, 0)->nullable(); // Más Autoretenciones De Impuestos De Avisos Y Tableros
            $table->decimal('total_autoretencion_mensual', 15, 0)->nullable(); // Total Autoretención Mensual A Cargo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('declaracionesmensuales');
    }
};
