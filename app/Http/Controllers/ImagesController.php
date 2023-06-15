<?php

namespace App\Http\Controllers;

use App\Models\Images;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    //
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required',
                'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048',

            ]);
            $nombre = $request->get('nombre');
            $imagen = $request->file('imagen');
            $imagen->store('public/images');

            $createdImagen = Images::create([
                'nombre'=>$nombre,
                'imagen'=>$imagen
            ]);
            return response($createdImagen, 201);
        } catch (\Throwable $error) {
            return $error->getMessage();
        }



        // $user = new Imagen();
        // $user->nombre = $request->nombre;

        // if ($request->hasFile('imagen')) {
        //     $imagen = $request->file('imagen');
        //     $rutaImagen = $imagen->store('public/images');
        //     $user->imagen = $rutaImagen;
        // }

        // $user->save();

        // return response()->json(['message' => 'Usuario registrado correctamente'], 201);
    }
}
