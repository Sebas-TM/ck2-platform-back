<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;

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
    Route::get('/list',[UsuariosController::class,'listUsuarios']);
    Route::get('/list/{id}',[UsuariosController::class,'listUsuario']);
    Route::post('/update/{id}',[UsuariosController::class,'updateUsuario']);
    Route::delete('/delete/{id}',[UsuariosController::class,'destroyUsuarios']);
});

/**
* ==========================
* ====     AREAS     ====
* ==========================
*/