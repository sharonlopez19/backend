<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\rolController;
use App\Http\Controllers\Api\generoController;
use App\Http\Controllers\Api\NacionalidadController;
use App\Http\Controllers\Api\usuarioController;
use App\Http\Controllers\Api\epsController;
use App\Http\Controllers\Api\estadoCivilController;
use App\Http\Controllers\Api\hojasvidaController;
use App\Http\Controllers\Api\incapacidadController;
use App\Http\Controllers\Api\pazysalvoController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:api')->get('/me', [AuthController::class, 'me']);


Route::middleware('auth:api')->group(function () {
    // aquí van todas las rutas protegidas
});

// Rutas de ROL
Route::get('/rols', [rolController::class, 'index']);
Route::post('/rols', [rolController::class, 'store']);
Route::put('/rols/{id}', [rolController::class, 'update']);
Route::get('/rols/{id}', [rolController::class, 'show']);
Route::patch('/rols/{id}', [rolController::class, 'updatePartial']);
Route::delete('/rols/{id}', [rolController::class, 'destroy']);

// Rutas de GÉNERO
Route::get('/genero', [generoController::class, 'index']);
Route::post('/genero', [generoController::class, 'store']);
Route::put('/genero/{idGenero}', [generoController::class, 'update']);
Route::get('/genero/{id}', [generoController::class, 'show']);
Route::patch('/genero/{id}', [generoController::class, 'updatePartial']);
Route::delete('/genero/{id}', [generoController::class, 'destroy']);

// Rutas de NACIONALIDAD
Route::get('/nacionalidad', [NacionalidadController::class, 'index']);
Route::post('/nacionalidad', [NacionalidadController::class, 'store']);
Route::put('/nacionalidad/{idGenero}', [NacionalidadController::class, 'update']);
Route::get('/nacionalidad/{id}', [NacionalidadController::class, 'show']);
Route::patch('/nacionalidad/{id}', [NacionalidadController::class, 'updatePartial']);
Route::delete('/nacionalidad/{id}', [NacionalidadController::class, 'destroy']);

// Rutas de EPS
Route::get('/epss', [epsController::class, 'index']);
Route::post('/epss', [epsController::class, 'store']);
Route::put('/epss/{id}', [epsController::class, 'update']);
Route::get('/epss/{id}', [epsController::class, 'show']);
Route::patch('/epss/{id}', [epsController::class, 'updatePartial']);
Route::delete('/epss/{id}', [epsController::class, 'destroy']);

// Rutas de ESTADO CIVIL
Route::get('/estadocivil', [EstadoCivilController::class, 'index']);
Route::post('/estadocivil', [EstadoCivilController::class, 'store']);
Route::put('/estadocivil/{id}', [EstadoCivilController::class, 'update']);
Route::get('/estadocivil/{id}', [EstadoCivilController::class, 'show']);
Route::patch('/estadocivil/{id}', [EstadoCivilController::class, 'updatePartial']);
Route::delete('/estadocivil/{id}', [EstadoCivilController::class, 'destroy']);

// Rutas de HOJAS DE VIDA
Route::get('/hojasvida', [hojasvidaController::class, 'index']);
Route::post('/hojasvida', [hojasvidaController::class, 'store']);
Route::put('/hojasvida/{id}', [hojasvidaController::class, 'update']);
Route::get('/hojasvida/{id}', [hojasvidaController::class, 'show']);
Route::patch('/hojasvida/{id}', [hojasvidaController::class, 'updatePartial']);
Route::delete('/hojasvida/{id}', [hojasvidaController::class, 'destroy']);

Route::get('/usuarios', [usuarioController::class, 'index']);
Route::post('/usuarios', [usuarioController::class, 'store']);
Route::put('/usuarios/{id}', [usuarioController::class, 'update']);
Route::get('/usuarios/{id}', [usuarioController::class, 'show']);
Route::patch('/usuarios/{id}', [usuarioController::class, 'updatePartial']);
Route::delete('/usuarios/{id}', [usuarioController::class, 'destroy']);

Route::get('/incapacidad', [incapacidadController::class, 'index']);
Route::post('/incapacidad', [incapacidadController::class, 'store']);
Route::put('/incapacidad/{id}', [incapacidadController::class, 'update']);
Route::get('/incapacidad/{id}', [incapacidadController::class, 'show']);
Route::patch('/incapacidad/{id}', [incapacidadController::class, 'updatePartial']);
Route::delete('/incapacidad/{id}', [incapacidadController::class, 'destroy']);

Route::get('/pazysalvo', [pazysalvoController::class, 'index']);
Route::post('/pazysalvo', [pazysalvoController::class, 'store']);
Route::put('/pazysalvo/{id}', [pazysalvoController::class, 'update']);
Route::get('/pazysalvo/{id}', [pazysalvoController::class, 'show']);
Route::patch('/pazysalvo/{id}', [pazysalvoController::class, 'updatePartial']);
Route::delete('/pazysalvo/{id}', [pazysalvoController::class, 'destroy']);