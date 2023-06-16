<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleados extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'imagen',
        'estado',
        'dni',
        'correo',
        'celular',
        'nombre_contacto',
        'numero_contacto',
        'relacion_contacto',
        'area',
        'puesto',
        'jefe_inmediato'
    ];
}
