<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuarios;

class UsuariosController extends Controller
{
    //
    function createUsuarios(Request $request){
        $nombre = $request->get('nombre');
        $apellido_paterno = $request->get('apellido_paterno');
        $apellido_materno = $request->get('apellido_materno');
        $dni = $request->get('dni');
        $username = $request->get('username');
        $password = $request->get('password');
        $isAdmin = $request->get('isAdmin');

        $encrypted_password = Hash::make($password);
        $createdUsuario = Usuarios::create([
            'nombre'=>$nombre,
            'apellido_paterno'=>$apellido_paterno,
            'apellido_materno'=>$apellido_materno,
            'dni'=>$dni,
            'username'=>$username,
            'password'=>$encrypted_password,
            'isAdmin'=>$isAdmin
        ]);
        return response($createdUsuario, 201);
    }  

    function loginUsuarios(Request $request){
        $credentials = $request->only('username', 'password');

        $user = Usuarios::where('username',$credentials['username'])->first();

        if(!$user || !Hash::check($credentials['password'], $user->password)){
            return 0;
        }

        return $user;


    }

    function listUsuarios(Request $request){
        $listedUsuarios = Usuarios::all();
        return response($listedUsuarios,200);
    }

    function listUsuario($id){
        $listedUsuario = Usuarios::find($id);
        if(!$listedUsuario){
            return response(['message'=>'No se encontró el usuario'],404);
        }
        return response($listedUsuario,200);
    }

    function updateUsuario(Request $request, $id){
        $usuario = Usuarios::find($id);

        if(!$usuario){
            return response(['message'=>'No se pudo guardar los cambios'],404);
        }

        $nombre = $request->get('nombre');
        $apellido_paterno = $request->get('apellido_paterno');
        $apellido_materno = $request->get('apellido_materno');
        $username = $request->get('username');
        $dni = $request->get('dni');
        $password = $request->get('password');
        $isAdmin = $request->get('isAdmin');

        $usuario->update([
            'nombre'=>$nombre,
            'apellido_paterno'=>$apellido_paterno,
            'apellido_materno'=>$apellido_materno,
            'username'=>$username,
            'dni'=>$dni,
            'password'=>$password,
            'isAdmin'=>$isAdmin
        ]);

        return response(['message'=>'Usuario actualizado'],201);
    }

    public function destroyUsuarios($id){
        $user = Usuarios::find($id);

        if(!$user){
            return response('Usuario no encontrado');
        }

        $user->delete();
        return response('Usuario eliminado exitosamente');

    }
        
        // 'nombre',
        // 'apellido_paterno',
        // 'apellido_materno',
        // 'username',
        // 'dni',
        // 'password',
        // 'isAdmin'
    
}
