<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Imagen;
use Illuminate\Http\Request;

class ImagenController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = new Imagen();
        $user->nombre = $request->nombre;

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $rutaImagen = $imagen->store('public/images');
            $user->imagen = $rutaImagen;
        }

        $user->save();

        return response()->json(['message' => 'Usuario registrado correctamente'], 201);
    }
}
