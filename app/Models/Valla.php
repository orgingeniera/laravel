<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valla extends Model
{
    use HasFactory;
    protected $table = 'vallas';
    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'opcion',
        'n_registro',
        'fecha_instalacion',
        'lugar_instalacion',
        'donde_instalo',
        'base_gravable',
        'impuesto_pagar',
        'contribuyente_id',
        'image_path',
        'image_url' 
    ];

    // Relación inversa con el modelo Contribuyente
    public function contribuyente()
    {
        return $this->belongsTo(Contribuyente::class);
    }
}
