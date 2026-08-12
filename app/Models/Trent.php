<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trent extends Model
{
    /** @use HasFactory<\Database\Factories\TrentFactory> */
    use HasFactory;
    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'email',
        'telefono'
    ];
}
