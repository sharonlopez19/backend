<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\rolController;
use App\Http\Controllers\Api\generoController;
use App\Http\Controllers\Api\NacionalidadController;


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