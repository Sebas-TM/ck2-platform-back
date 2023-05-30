<?php

namespace App\Http\Controllers;
use App\Models\Empleados;


use Illuminate\Http\Request;

class EmpleadosController extends Controller
{
    //
    function createEmpleados(Request $request){
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

        $createdEmpleados = Empleados::create([
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

        return response($createdEmpleados, 201);
    }

    function listEmpleados(Request $request){
        $listedEmpleados = Empleados::all();
        return response($listedEmpleados, 200);
    }
}
