<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Empleados;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Throwable;

class EmpleadosController extends Controller
{
    //
    function createEmpleados(Request $request)
    {

        try {
            $request->validate([
                'imagen' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            $validator = Validator::make($request->all(), [
                'dni' => [
                    Rule::unique('empleados')
                ]
            ]);

            if ($validator->fails()) {
                return response(['message' => 'El DNI ya ha sido registrado'], 422);
            }

            $nombre = $request->get('nombre');
            $apellido_paterno = $request->get('apellido_paterno');
            $apellido_materno = $request->get('apellido_materno');
            $imagen = $request->file('imagen');
            $estado = $request->get('estado');
            $dni = $request->get('dni');
            $correo = $request->get('correo');
            $celular = $request->get('celular');
            $nombre_contacto = $request->get('nombre_contacto');
            $numero_contacto = $request->get('numero_contacto');
            $relacion_contacto = $request->get('relacion_contacto');
            $area = $request->get('area');
            $puesto = $request->get('puesto');
            $jefe_inmediato = $request->get('jefe_inmediato');
            $fecha_certificacion = $request->get('fecha_certificacion');
            $grupo = $request->get('grupo');
            $sede = $request->get('sede');

            if (!$request->hasFile('imagen')) {
                $createdEmpleados = Empleados::create([
                    'nombre' => $nombre,
                    'apellido_paterno' => $apellido_paterno,
                    'apellido_materno' => $apellido_materno,
                    'estado' => $estado,
                    'dni' => $dni,
                    'correo' => $correo,
                    'celular' => $celular,
                    'nombre_contacto' => $nombre_contacto,
                    'numero_contacto' => $numero_contacto,
                    'relacion_contacto' => $relacion_contacto,
                    'area' => $area,
                    'puesto' => $puesto,
                    'jefe_inmediato' => $jefe_inmediato,
                    'fecha_certificacion' => $fecha_certificacion,
                    'grupo' => $grupo,
                    'sede' => $sede
                ]);

                return response($createdEmpleados, 201);
            } else {
                $nombreImagen = $dni . '.' . $imagen->getClientOriginalExtension();
                $imagen->storeAs('public/images', $nombreImagen);
                $rutaImagen = $imagen->storeAs('storage/images', $nombreImagen);

                $resizedImage = Image::make($rutaImagen)->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $resizedImage->save($rutaImagen);

                $createdEmpleados = Empleados::create([
                    'nombre' => $nombre,
                    'apellido_paterno' => $apellido_paterno,
                    'apellido_materno' => $apellido_materno,
                    'imagen' => $rutaImagen,
                    'estado' => $estado,
                    'dni' => $dni,
                    'correo' => $correo,
                    'celular' => $celular,
                    'nombre_contacto' => $nombre_contacto,
                    'numero_contacto' => $numero_contacto,
                    'relacion_contacto' => $relacion_contacto,
                    'area' => $area,
                    'puesto' => $puesto,
                    'jefe_inmediato' => $jefe_inmediato,
                    'fecha_certificacion' => $fecha_certificacion,
                    'grupo' => $grupo,
                    'sede' => $sede
                ]);

                return response($createdEmpleados, 201);
            }
        } catch (\Throwable $error) {
            return $error->getMessage();
        }
    }

    function searchEmpleado(Request $request)
    {
        try {
            $termino = $request->get('termino');

            $table = with(new Empleados())->getTable();
            $columns = \Illuminate\Support\Facades\Schema::getColumnListing($table);

            $query = Empleados::query();
            foreach ($columns as $column) {
                $query->orWhere($column, 'LIKE', "%{$termino}%");
            }

            $results = $query->paginate(15);

            return response()->json($results);
        } catch (Throwable $error) {
            return response(["message" => $error]);
        }
    }

    function listAllEmpleados(Request $request)
    {
        $listedAllEmpleados = Empleados::all();
        return response($listedAllEmpleados, 200);
    }


    function listEmpleados(Request $request)
    {
        $listedEmpleados = Empleados::orderBy('id', 'desc')->paginate(15);
        return response()->json([
            'meta' => [
                'current_page' => $listedEmpleados->currentPage(),
                'last_page' => $listedEmpleados->lastPage(),
                'per_page' => $listedEmpleados->perPage(),
                'total' => $listedEmpleados->total()
            ],
            'data' => $listedEmpleados->items()
        ]);
    }

    function listEmpleado($id)
    {
        $listedEmpleado = Empleados::find($id);
        if (!$listedEmpleado) {
            return response(['message' => 'No se encontró el usuario'], 404);
        }
        return response($listedEmpleado, 200);
    }

    public function destroyEmpleados($id)
    {
        $employee = Empleados::find($id);

        if (!$employee) {
            return response('Empleado no encontrado');
        }

        $employee->delete();
        return response('Empleado eliminado exitosamente');
    }

    function updateEmpleado(Request $request, $id)
    {

        $empleado = Empleados::find($id);
        if (!$empleado) {
            return response(['message' => 'No se pudieron guardar los cambios'], 404);
        }

        $request->validate([
            'imagen' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $validator = Validator::make($request->all(), [
            'dni' => [
                Rule::unique('empleados')->ignore($id),
            ],
        ]);

        if ($validator->fails()) {
            return response(['message' => 'El DNI ya ha sido registrado'], 422);
        }

        $nombre = $request->get('nombre');
        $apellido_paterno = $request->get('apellido_paterno');
        $apellido_materno = $request->get('apellido_materno');
        $imagen = $request->file('imagen');
        $estado = $request->get('estado');
        $dni = $request->get('dni');
        $correo = $request->get('correo');
        $celular = $request->get('celular');
        $nombre_contacto = $request->get('nombre_contacto');
        $numero_contacto = $request->get('numero_contacto');
        $relacion_contacto = $request->get('relacion_contacto');
        $area = $request->get('area');
        $puesto = $request->get('puesto');
        $jefe_inmediato = $request->get('jefe_inmediato');
        $fecha_certificacion = $request->get('fecha_certificacion');
        $grupo = $request->get('grupo');
        $sede = $request->get('sede');



        if (!$request->hasFile('imagen')) {
            $empleado->update([
                'nombre' => $nombre,
                'apellido_paterno' => $apellido_paterno,
                'apellido_materno' => $apellido_materno,
                'estado' => $estado,
                'dni' => $dni,
                'correo' => $correo,
                'celular' => $celular,
                'nombre_contacto' => $nombre_contacto,
                'numero_contacto' => $numero_contacto,
                'relacion_contacto' => $relacion_contacto,
                'area' => $area,
                'puesto' => $puesto,
                'jefe_inmediato' => $jefe_inmediato,
                'fecha_certificacion' => $fecha_certificacion,
                'grupo' => $grupo,
                'sede' => $sede
            ]);

            return response(['message' => 'Empleado actualizado'], 201);
        } else {

            $nombreImagen = $dni . '.' . $imagen->getClientOriginalExtension();
            $imagen->storeAs('public/images', $nombreImagen);
            $rutaImagen = $imagen->storeAs('storage/images', $nombreImagen);

            $resizedImage = Image::make($rutaImagen)->resize(150, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $resizedImage->save($rutaImagen);

            $empleado->update([
                'nombre' => $nombre,
                'apellido_paterno' => $apellido_paterno,
                'apellido_materno' => $apellido_materno,
                'imagen' => $rutaImagen,
                'estado' => $estado,
                'dni' => $dni,
                'correo' => $correo,
                'celular' => $celular,
                'nombre_contacto' => $nombre_contacto,
                'numero_contacto' => $numero_contacto,
                'relacion_contacto' => $relacion_contacto,
                'area' => $area,
                'puesto' => $puesto,
                'jefe_inmediato' => $jefe_inmediato,
                'fecha_certificacion' => $fecha_certificacion,
                'grupo' => $grupo,
                'sede' => $sede
            ]);

            return response(['message' => 'Empleado actualizado'], 201);
        }
    }
}
