<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VallasImagen extends Model
{
    use HasFactory;
    protected $table = 'imagenvallas';

    protected $fillable = ['vallas_id', 'image_path', 'image_url'];

    public function vallas()
    {
        return $this->belongsTo(Vallas::class);
    }
   
}
