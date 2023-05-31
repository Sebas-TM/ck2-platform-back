<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Personal;



class PersonalController extends Controller
{
    //
    function createPersonal(Request $request){
        $nombre = $request->get('nombre');
        $apellido_paterno = $request->get('apellido_paterno');
        $apellido_materno = $request->get('apellido_materno');
        $estado = $request->get('estado');
        $dni = $request->get('dni');
        $correo = $request->get('correo');
        $telefono = $request->get('telefono');
        $area = $request->get('area');
        $sala = $request->get('sala');
        $cargo = $request->get('cargo');
        $jefe_directo = $request->get('jefe_directo');

        $createdPersonal = Personal::create([
            'nombre'=>$nombre,
            'apellido_paterno'=>$apellido_paterno,
            'apellido_materno'=>$apellido_materno,
            'estado'=>$estado,
            'dni'=>$dni,
            'correo'=>$correo,
            'telefono'=>$telefono,
            'area'=>$area,
            'sala'=>$sala,
            'cargo'=>$cargo,
            'jefe_directo'=>$jefe_directo
        ]);

        return response($createdPersonal, 201);
    }

    function listPersonal(Request $request){
        $listedPersonal = Personal::all();
        return response($listedPersonal, 200);
    }


    //      'nombre',
    //     'apellido_paterno',
    //     'apellido_materno',
    //     'dni',
    //     'correo',
    //     'telefono',
    //     'area',
    //     'sala',
    //     'cargo',
    //     'jefe_directo'
}
