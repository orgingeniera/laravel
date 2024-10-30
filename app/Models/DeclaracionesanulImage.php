<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeclaracionesanulImage extends Model
{
    use HasFactory;

    protected $fillable = ['declaracionesanul_id', 'image_path', 'image_url'];

    public function declaracionesanul()
    {
        return $this->belongsTo(Declaracionesanul::class);
    }
}
