<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\rolController;
use App\Http\Controllers\Api\generoController;
use App\Http\Controllers\Api\NacionalidadController;
use App\Http\Controllers\Api\epsController;
use App\Http\Controllers\Api\estadocivilController;
use App\Http\Controllers\Api\hojasvidaController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('/me', [AuthController::class, 'me']);

Route::get('/rols', [rolController::class, 'index']);
Route::post('/rols', [rolController::class, 'store']);
Route::put('/rols/{id}', [rolController::class, 'update']);
Route::get('/rols/{id}', [rolController::class, 'show']);
Route::patch('/rols/{id}', [rolController::class, 'updatePartial']);
Route::delete('/rols/{id}', [rolController::class, 'destroy']);

Route::get('/genero', [generoController::class, 'index']);
Route::post('/genero', [generoController::class, 'store']);
Route::put('/genero/{idGenero}', [generoController::class, 'update']);
Route::get('/genero/{id}', [generoController::class, 'show']);
Route::patch('/genero/{id}', [generoController::class, 'updatePartial']);
Route::delete('/genero/{id}', [generoController::class, 'destroy']);

Route::get('/nacionalidad', [NacionalidadController::class, 'index']);
Route::post('/nacionalidad', [NacionalidadController::class, 'store']);
Route::put('/nacionalidad/{idGenero}', [NacionalidadController::class, 'update']);
Route::get('/nacionalidad/{id}', [NacionalidadController::class, 'show']);
Route::patch('/nacionalidad/{id}', [NacionalidadController::class, 'updatePartial']);
Route::delete('/nacionalidad/{id}', [NacionalidadController::class, 'destroy']);

Route::get('/epss', [epsController::class, 'index']);
Route::post('/epss', [epsController::class, 'store']);
Route::put('/epss/{id}', [epsController::class, 'update']);
Route::get('/epss/{id}', [epsController::class, 'show']);
Route::patch('/epss/{id}', [epsController::class, 'updatePartial']);
Route::delete('/epss/{id}', [epsController::class, 'destroy']);

Route::get('/estadocivil', [estadocivilController::class, 'index']);
Route::post('/estadocivil', [estadocivilController::class, 'store']);
Route::put('/estadocivil/{id}', [estadocivilController::class, 'update']);
Route::get('/estadocivil/{id}', [estadocivilController::class, 'show']);
Route::patch('/estadocivil/{id}', [estadocivilController::class, 'updatePartial']);
Route::delete('/estadocivil/{id}', [estadocivilController::class, 'destroy']);

Route::get('/hojasvida', [hojasvidaController::class, 'index']);
Route::post('/hojasvida', [hojasvidaController::class, 'store']);
Route::put('/hojasvida/{id}', [hojasvidaController::class, 'update']);
Route::get('/hojasvida/{id}', [hojasvidaController::class, 'show']);
Route::patch('/hojasvida/{id}', [hojasvidaController::class, 'updatePartial']);
Route::delete('/hojasvida/{id}', [hojasvidaController::class, 'destroy']);