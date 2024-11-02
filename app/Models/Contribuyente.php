<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribuyente extends Model
{
    use HasFactory;
    protected $table = 'contribuyentes';
    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'nombre',
        'apellido',
        'tipo_identificacion',
        'identificacion',
        'dv',
        'telefono',
        'direccion',
        'municipio',
        'departamento',
    ];

    // Relación uno a muchos con el modelo Valla
    public function vallas()
    {
        return $this->hasMany(Valla::class);
    }
}
