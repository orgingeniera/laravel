<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeclaracionAnul extends Model
{
    use HasFactory;

    // Especificar la tabla si el nombre no sigue las convenciones de Laravel
    protected $table = 'declaracionesanul';

    // Definir los campos que pueden ser llenados
    protected $fillable = [
        'n_declaracion',
        'vigencia',
        'fecha_declaracion',
        'nit_contribuyente',
        'razon_social',
        'regimen',
        'direccion',
        'ciudad',
        'correo_electronico',
        'total_ingresos_nacionales',
        'menos_ingresos_fuera_municipio',
        'total_ingresos_municipio',
        'menos_ingresos_rebajas',
        'menos_ingresos_exportaciones',
        'menos_ingresos_venta_activos',
        'menos_ingresos_no_gravados',
        'menos_ingresos_exentos',
        'total_ingresos_gravables',
        'total_impuesto',
        'capacidad_kw',
        'impuesto_ley_56',
        'total_industria_comercio',
        'impuesto_avisos_tableros',
        'pago_unidades_adicionales',
        'sobretasa_bomberil',
        'sobretasa_seguridad',
        'total_impuesto_cargo',
    ];

    // Las columnas created_at y updated_at se gestionan automáticamente
    public $timestamps = true;
   
}
