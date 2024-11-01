<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeclaracionMensual extends Model
{
    use HasFactory;

    // Especificar la tabla si el nombre no sigue las convenciones de Laravel
    protected $table = 'declaracionesmensuales';

    // Definir los campos que pueden ser llenados
    protected $fillable = [
    'n_declaracion',
    'vigencia',
    'periodo', // Campo de tipo string
    'fecha_declaracion',
    'nit_contribuyente',
    'razon_social',
    'regimen',
    'direccion',
    'ciudad',
    'correo_electronico',
    'total_ingresos_brutos', // Total Ingresos Brutos Ordinarios Y Extraordinarios
    'menos_devoluciones_subsidios', // Menos Devoluciones y Subsidios
    'menos_ingresos_fuera_municipio', // Menos Ingresos Obtenidos Fuera De Este Municipio
    'menos_ventas_activos_exportacion', // Menos Ventas De Activos Fijos Y Ventas De Exportacion
    'menos_ingresos_exentos_no_sujetos', // Menos Ingresos Por Actividades Exentas Y No Sujetas
    'total_ingresos_gravables', // Total Ingresos Gravables Autoretencion
    'autoretencion_impuesto_industria_comercio', // Autoretención De Impuesto De Industria Y Comercio
    'mas_autoretenciones_impuestos_avisos_tableros', // Más Autoretenciones De Impuestos De Avisos Y Tableros
    'total_autoretencion_mensual', 
    ];
    public function images()
    {
        return $this->hasMany(DeclaracionesanulImage::class);
    }
    // Las columnas created_at y updated_at se gestionan automáticamente
    public $timestamps = true;
   
}
