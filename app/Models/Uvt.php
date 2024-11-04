<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uvt extends Model
{
    use HasFactory;
    protected $table = 'uvts';
    protected $fillable = ['valor'];
}

