<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Puestos ;

class PuestosController extends Controller
{
    //
    function createPuestos(Request $request){
        $puesto = $request->get('puesto');

        $createdPuestos = Puestos::create([
            'puesto'=>$puesto
        ]);

        return response($createdPuestos, 201);
    }

    function listPuestos(Request $request){
        $listedPuestos = Puestos::all();
        return response($listedPuestos, 200);
    }

    function listPuesto(Request $request, $id){
        $listedPuesto = Puestos::find($id);
        if(!$listedPuesto){
            return response(['message'=>'No se encontró el puesto',404]);
        }
        return response($listedPuesto, 200);
    }

    function updatePuesto(Request $request, $id){
        $puesto0 =  Puestos::find($id);
        if(!$puesto0){
            return response(['message'=>'No se pudieron guardar los cambios'],404);
        }

        $puesto = $request->get('puesto');

        $puesto0->update([
            'puesto'=>$puesto
        ]);

        return response(['message'=>'Puesto actualizado'],201);
    }

    function destroyPuesto($id){
        $puesto = Puestos::find($id);

        if(!$puesto){
            return response('Puesto no encontrado');
        }

        $puesto->delete();
        return response('Puesto eliminado exitosamente');
    }
}
