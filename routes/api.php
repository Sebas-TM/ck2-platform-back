<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\AreasController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
* ==========================
* ====     USUARIOS     ====
* ==========================
*/
Route::prefix('/users')->group(function(){
    Route::post('/create',[UsuariosController::class,'createUsuarios']); 
    Route::post('/login',[UsuariosController::class,'loginUsuarios']); 
    Route::get('/list',[UsuariosController::class,'listUsuarios']);
    Route::get('/list/{id}',[UsuariosController::class,'listUsuario']);
    Route::post('/update/{id}',[UsuariosController::class,'updateUsuario']);
    Route::delete('/delete/{id}',[UsuariosController::class,'destroyUsuarios']); 
});

/**
* ==========================
* ====     EMPLEADOS    ====
* ==========================
*/
Route::prefix('/employees')->group(function(){
    Route::post('/create',[EmpleadosController::class,'createEmpleados']);
    Route::get('/list',[EmpleadosController::class,'listEmpleados']);
    Route::get('/list/{id}',[EmpleadosController::class,'listEmpleado']);
    Route::post('update/{id}',[EmpleadosController::class,'updateEmpleado']);
    Route::delete('/delete/{id}',[EmpleadosController::class,'destroyEmpleados']);
});

/**
* ==========================
* ====      AREAS       ====
* ==========================
*/

Route::prefix('/areas')->group(function(){
    Route::post('/create',[AreasController::class,'createAreas']);
    Route::get('/list',[AreasController::class,'listAreas']);
    Route::get('/list/{id}',[AreasController::class,'listArea']);
    Route::post('/update/{id}',[AreasController::class,'updateArea']);
    Route::delete('/delete/{id}',[AreasController::class,'destroyAreas']);
});
