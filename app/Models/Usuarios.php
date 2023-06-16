<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Usuarios extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'dni',
        'imagen',
        'username',
        'password',
        'isAdmin'
    ];

    // public function setPasswordAttribute($value){
    //     $this->attributes['password'] = Hash::make($value);
    // }
}
