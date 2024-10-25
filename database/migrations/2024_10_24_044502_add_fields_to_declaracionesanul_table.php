<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToDeclaracionesanulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('declaracionesanul', function (Blueprint $table) {
            $table->string('n_declaracion', 50)->nullable();
            $table->year('vigencia')->nullable();
            $table->date('fecha_declaracion')->nullable();
            $table->string('nit_contribuyente', 20)->nullable();
            $table->string('razon_social', 255)->nullable();
            $table->string('regimen', 50)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->string('ciudad', 100)->nullable();
            $table->string('correo_electronico', 100)->nullable();
            $table->decimal('total_ingresos_nacionales', 15, 2)->nullable();
            $table->decimal('menos_ingresos_fuera_municipio', 15, 2)->nullable();
            $table->decimal('total_ingresos_municipio', 15, 2)->nullable();
            $table->decimal('menos_ingresos_rebajas', 15, 2)->nullable();
            $table->decimal('menos_ingresos_exportaciones', 15, 2)->nullable();
            $table->decimal('menos_ingresos_venta_activos', 15, 2)->nullable();
            $table->decimal('menos_ingresos_no_gravados', 15, 2)->nullable();
            $table->decimal('menos_ingresos_exentos', 15, 2)->nullable();
            $table->decimal('total_ingresos_gravables', 15, 2)->nullable();
            $table->decimal('total_impuesto', 15, 2)->nullable();
            $table->decimal('capacidad_kw', 15, 2)->nullable();
            $table->decimal('impuesto_ley_56', 15, 2)->nullable();
            $table->decimal('total_industria_comercio', 15, 2)->nullable();
            $table->decimal('impuesto_avisos_tableros', 15, 2)->nullable();
            $table->decimal('pago_unidades_adicionales', 15, 2)->nullable();
            $table->decimal('sobretasa_bomberil', 15, 2)->nullable();
            $table->decimal('sobretasa_seguridad', 15, 2)->nullable();
            $table->decimal('total_impuesto_cargo', 15, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('declaracionesanul', function (Blueprint $table) {
            $table->dropColumn([
                'n_declaracion', 'vigencia', 'fecha_declaracion', 'nit_contribuyente',
                'razon_social', 'regimen', 'direccion', 'ciudad', 'correo_electronico',
                'total_ingresos_nacionales', 'menos_ingresos_fuera_municipio', 'total_ingresos_municipio',
                'menos_ingresos_rebajas', 'menos_ingresos_exportaciones', 'menos_ingresos_venta_activos',
                'menos_ingresos_no_gravados', 'menos_ingresos_exentos', 'total_ingresos_gravables',
                'total_impuesto', 'capacidad_kw', 'impuesto_ley_56', 'total_industria_comercio',
                'impuesto_avisos_tableros', 'pago_unidades_adicionales', 'sobretasa_bomberil',
                'sobretasa_seguridad', 'total_impuesto_cargo'
            ]);
        });
    }
}
