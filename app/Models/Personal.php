<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'estado',
        'dni',
        'correo',
        'telefono',
        'area',
        'sala',
        'cargo',
        'jefe_directo'
    ];
}
