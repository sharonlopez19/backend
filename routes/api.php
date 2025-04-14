<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\RolController;
use App\Http\Controllers\Api\GeneroController;
use App\Http\Controllers\Api\NacionalidadController;
use App\Http\Controllers\Api\EpsController;
use App\Http\Controllers\Api\EstadoCivilController;
use App\Http\Controllers\Api\HojasVidaController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

// Registro y login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Obtener datos del usuario autenticado
Route::middleware('auth:api')->get('/me', [AuthController::class, 'me']);

/*
|--------------------------------------------------------------------------
| Rutas Protegidas con Middleware 'auth:api' (si aplica)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    // aquí van todas las rutas protegidas
});

// Rutas de ROL
Route::get('/rols', [RolController::class, 'index']);
Route::post('/rols', [RolController::class, 'store']);
Route::put('/rols/{id}', [RolController::class, 'update']);
Route::get('/rols/{id}', [RolController::class, 'show']);
Route::patch('/rols/{id}', [RolController::class, 'updatePartial']);
Route::delete('/rols/{id}', [RolController::class, 'destroy']);

// Rutas de GÉNERO
Route::get('/genero', [GeneroController::class, 'index']);
Route::post('/genero', [GeneroController::class, 'store']);
Route::put('/genero/{idGenero}', [GeneroController::class, 'update']);
Route::get('/genero/{id}', [GeneroController::class, 'show']);
Route::patch('/genero/{id}', [GeneroController::class, 'updatePartial']);
Route::delete('/genero/{id}', [GeneroController::class, 'destroy']);

// Rutas de NACIONALIDAD
Route::get('/nacionalidad', [NacionalidadController::class, 'index']);
Route::post('/nacionalidad', [NacionalidadController::class, 'store']);
Route::put('/nacionalidad/{idGenero}', [NacionalidadController::class, 'update']);
Route::get('/nacionalidad/{id}', [NacionalidadController::class, 'show']);
Route::patch('/nacionalidad/{id}', [NacionalidadController::class, 'updatePartial']);
Route::delete('/nacionalidad/{id}', [NacionalidadController::class, 'destroy']);

// Rutas de EPS
Route::get('/epss', [EpsController::class, 'index']);
Route::post('/epss', [EpsController::class, 'store']);
Route::put('/epss/{id}', [EpsController::class, 'update']);
Route::get('/epss/{id}', [EpsController::class, 'show']);
Route::patch('/epss/{id}', [EpsController::class, 'updatePartial']);
Route::delete('/epss/{id}', [EpsController::class, 'destroy']);

// Rutas de ESTADO CIVIL
Route::get('/estadocivil', [EstadoCivilController::class, 'index']);
Route::post('/estadocivil', [EstadoCivilController::class, 'store']);
Route::put('/estadocivil/{id}', [EstadoCivilController::class, 'update']);
Route::get('/estadocivil/{id}', [EstadoCivilController::class, 'show']);
Route::patch('/estadocivil/{id}', [EstadoCivilController::class, 'updatePartial']);
Route::delete('/estadocivil/{id}', [EstadoCivilController::class, 'destroy']);

// Rutas de HOJAS DE VIDA
Route::get('/hojasvida', [HojasVidaController::class, 'index']);
Route::post('/hojasvida', [HojasVidaController::class, 'store']);
Route::put('/hojasvida/{id}', [HojasVidaController::class, 'update']);
Route::get('/hojasvida/{id}', [HojasVidaController::class, 'show']);
Route::patch('/hojasvida/{id}', [HojasVidaController::class, 'updatePartial']);
Route::delete('/hojasvida/{id}', [HojasVidaController::class, 'destroy']);


