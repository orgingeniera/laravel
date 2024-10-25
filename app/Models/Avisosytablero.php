<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avisosytablero extends Model
{
    use HasFactory;

    protected $fillable = [
        'nit',
        'telefono',
        'direccion',
        'concepto',
        'ica',
        'navisosytableros',
        'autobimestral'
    ];

    // Especifica el nombre de la tabla
    protected $table = 'avisosytablero';
}
