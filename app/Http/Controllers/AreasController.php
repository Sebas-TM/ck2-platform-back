<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Areas;


class AreasController extends Controller
{
    //
    function createAreas(Request $request){
        $area = $request->get('area');

        $createdAreas = Areas::create([
            'area'=>$area
        ]);

        return response($createdAreas, 201);
    }

    function listAreas(Request $request){
        $listedAreas = Areas::all();
        return response($listedAreas, 200);
    }

    function listArea($id){
        $listedArea = Areas::find($id);
        if(!$listedArea){
            return response(['message'=>'No se encontró la área'],404);
        }
        return response($listedArea,200);
    }

    function updateArea(Request $request, $id){
        $area0 = Areas::find($id);
        if(!$area0){
            return response(['message'=>'No se pudieron guardar los cambios'],404);
        }

        $area = $request->get('area');

        $area0->update([
            'area'=>$area
        ]);

        return response(['message'=>'Area actualizada'],201);
    }

    function destroyAreas($id){
        $area = Areas::find($id);

        if(!$area){
            return response('Area no encontrada');
        }

        $area->delete();
        return response('Area eliminada exitosamente');
    }
}
