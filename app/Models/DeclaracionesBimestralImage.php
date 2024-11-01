<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeclaracionesBimestralImage extends Model
{
    use HasFactory;

    protected $fillable = ['declaracionesanul_id', 'image_path', 'image_url'];

    public function declaracionesanul()
    {
        return $this->belongsTo(Declaracionesanul::class);
    }
    public function declaracionesmensuales()
    {
        return $this->belongsTo(DeclaracionMensual::class);
    }
    public function declaracionesbimestrales()
    {
        return $this->belongsTo(DeclaracionBimestral::class);
    }
}
