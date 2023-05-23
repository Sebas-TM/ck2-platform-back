<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuarios;

class UsuariosController extends Controller
{
    //
    function createUsuarios(Request $request){
        $nombre = $request->get('nombre');
        $apellido_paterno = $request->get('apellido_paterno');
        $apellido_materno = $request->get('apellido_materno');
        $username = $request->get('username');
        $password = $request->get('password');
        $isAdmin = $request->get('isAdmin');

        $createdUsuario = Usuarios::create([
            'nombre'=>$nombre,
            'apellido_paterno'=>$apellido_paterno,
            'apellido_materno'=>$apellido_materno,
            'username'=>$username,
            'password'=>$password,
            'isAdmin'=>$isAdmin
        ]);
        return response($createdUsuario, 201);
    }

        function listUsuarios(Request $request){
            $listedUsuarios = Usuarios::all();
            return response($listedUsuarios,200);
        }
        
        // 'nombre',
        // 'apellido_paterno',
        // 'apellido_materno',
        // 'username',
        // 'password',
        // 'permiso'
    
}
