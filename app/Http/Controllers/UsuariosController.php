<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Usuarios;
use Throwable;

class UsuariosController extends Controller
{
    //
    function createUsuarios(Request $request)
    {

        try {
            $request->validate([
                'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $validator = Validator::make($request->all(),[
                'dni' => 'unique:usuarios',
                'username' => 'unique:usuarios'
            ]);

            $errors = $validator->errors();
            if($validator->fails()){
                if($errors->has('dni') && $errors->has('username')){
                    $errorMessage = 'El DNI y el nombre de usuario ya han sido registrados';
                } elseif($errors->has('dni')){
                    $errorMessage = 'El DNI ya ha sido registrado';
                } elseif($errors->has('username')){
                    $errorMessage = 'El nombre de usuario ya ha sido registrado';
                }    
                
                return response(['message' => $errorMessage],422);
            }
            

            $nombre = $request->get('nombre');
            $apellido_paterno = $request->get('apellido_paterno');
            $apellido_materno = $request->get('apellido_materno');
            $dni = $request->get('dni');
            $imagen = $request->file('imagen');
            $username = $request->get('username');
            $password = $request->get('password');
            $isAdmin = $request->get('isAdmin');

            if (!$request->hasFile('imagen')) {
                $encrypted_password = Hash::make($password);
                $createdUsuario = Usuarios::create([
                    'nombre' => $nombre,
                    'apellido_paterno' => $apellido_paterno,
                    'apellido_materno' => $apellido_materno,
                    'dni' => $dni,
                    'username' => $username,
                    'password' => $encrypted_password,
                    'isAdmin' => $isAdmin
                ]);
                return response($createdUsuario, 201);

            } else {
                $nombreImagen = $username . '.' . $imagen->getClientOriginalExtension();
                $imagen->storeAs('public/images', $nombreImagen);
                $rutaImagen = $imagen->storeAs('storage/images', $nombreImagen);

                $encrypted_password = Hash::make($password);
                $createdUsuario = Usuarios::create([
                    'nombre' => $nombre,
                    'apellido_paterno' => $apellido_paterno,
                    'apellido_materno' => $apellido_materno,
                    'dni' => $dni,
                    'imagen' => $rutaImagen,
                    'username' => $username,
                    'password' => $encrypted_password,
                    'isAdmin' => $isAdmin
                ]);
                return response($createdUsuario, 201);
            }
        } catch (\Throwable $error) {
            return $error->getMessage();
        }
    }

    function loginUsuarios(Request $request)
    {
        $credentials = $request->only('username', 'password');

        $user = Usuarios::where('username', $credentials['username'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return 0;
        }

        return $user;
    }

    function listUsuarios(Request $request)
    {
        $listedUsuarios = Usuarios::all();
        return response($listedUsuarios, 200);
    }

    function listUsuario($id)
    {
        $listedUsuario = Usuarios::find($id);
        if (!$listedUsuario) {
            return response(['message' => 'No se encontró el usuario'], 404);
        }
        return response($listedUsuario, 200);
    }

    function updateUsuario(Request $request, $id)
    {
        $usuario = Usuarios::find($id);

        if (!$usuario) {
            return response(['message' => 'No se pudo guardar los cambios'], 404);
        }

        $request->validate([
            'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validator = Validator::make($request->all(),[
            'dni' => [
                Rule::unique('usuarios')->ignore($id),
            ],
            'username' => [
                Rule::unique('usuarios')->ignore($id),
            ]
        ]);

        $errors = $validator->errors();
        if($validator->failed()){
            if($errors->has('dni') && $errors->has('username')){
                $errorMessage = 'El DNI y el nombre de usuario ya han sido registrados';
            } elseif($errors->has('dni')){
                $errorMessage = 'El DNI ya ha sido registrado';
            } elseif($errors->has('username')){
                $errorMessage = 'El nombre de usuario ya ha sido registrado';
            }    
            
            return response(['message' => $errorMessage],422);
        }

        $nombre = $request->get('nombre');
        $apellido_paterno = $request->get('apellido_paterno');
        $apellido_materno = $request->get('apellido_materno');
        $dni = $request->get('dni');
        $imagen = $request->file('imagen');
        $username = $request->get('username');
        $password = $request->get('password');
        $isAdmin = $request->get('isAdmin');

        if ($password == null && !$request->hasFile('imagen')) {
            $usuario->update([
                'nombre' => $nombre,
                'apellido_paterno' => $apellido_paterno,
                'apellido_materno' => $apellido_materno,
                'dni' => $dni,
                'username' => $username,
                'isAdmin' => $isAdmin
            ]);

            return response(['message' => 'Usuario actualizado'], 201);
        } else if ($password != null && !$request->hasFile('imagen')) {
            $encrypted_password = Hash::make($password);

            $usuario->update([
                'nombre' => $nombre,
                'apellido_paterno' => $apellido_paterno,
                'apellido_materno' => $apellido_materno,
                'dni' => $dni,
                'username' => $username,
                'password' => $encrypted_password,
                'isAdmin' => $isAdmin
            ]);

            return response(['message' => 'Usuario actualizado'], 201);
        } else if ($password == null && $request->hasFile('imagen')) {

            $nombreImagen = $dni . '.' . $imagen->getClientOriginalExtension();
            $imagen->storeAs('public/images', $nombreImagen);
            $rutaImagen = $imagen->storeAs('storage/images', $nombreImagen);

            $usuario->update([
                'nombre' => $nombre,
                'apellido_paterno' => $apellido_paterno,
                'apellido_materno' => $apellido_materno,
                'dni' => $dni,
                'imagen' => $rutaImagen,
                'username' => $username,
                'isAdmin' => $isAdmin
            ]);
        } else {
            $nombreImagen = $dni . '.' . $imagen->getClientOriginalExtension();
            $imagen->storeAs('public/images', $nombreImagen);
            $rutaImagen = $imagen->storeAs('storage/images', $nombreImagen);

            $encrypted_password = Hash::make($password);


            $usuario->update([
                'nombre' => $nombre,
                'apellido_paterno' => $apellido_paterno,
                'apellido_materno' => $apellido_materno,
                'dni' => $dni,
                'imagen' => $rutaImagen,
                'username' => $username,
                'password' => $encrypted_password,
                'isAdmin' => $isAdmin
            ]);
        }
    }

    public function destroyUsuarios($id)
    {
        $user = Usuarios::find($id);

        if (!$user) {
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
