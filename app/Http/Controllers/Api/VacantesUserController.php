<?php

namespace App\Http\Controllers\Api; // La namespace ahora incluye 'Api'

use App\Http\Controllers\Controller; // Sigue extendiendo la base Controller
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse; // Importar JsonResponse para tipado
// <<<< CORRECCIÓN: Importar la clase de modelo con el nombre correcto (Vacantes) >>>>
use App\Models\Vacantes;

class VacantesUserController extends Controller
{
    /**
     * Display a listing of the resource (vacantes) for public users.
     * Muestra un listado de las vacantes para usuarios públicos.
     */
    public function index(): JsonResponse
    {
        // Obtén las vacantes que quieres mostrar al público.
        // Puedes filtrar, ordenar o seleccionar campos específicos si es necesario.
        // Por ejemplo, solo las vacantes activas:
        // $vacantes = Vacantes::where('estado', 'activa')->orderBy('created_at', 'desc')->get(); // <<<< Usar Vacantes aquí si filtras

        // <<<< CORRECCIÓN: Usar la clase de modelo con el nombre correcto (Vacantes) >>>>
        $vacantes = Vacantes::all(); // Usar "Vacantes::all()"

        // Retorna las vacantes como una respuesta JSON.
        return response()->json($vacantes);
    }

    /**
     * Display the specified resource (vacante) for a public user.
     * Muestra una vacante específica para un usuario público.
     */
    public function show(string $id): JsonResponse
    {
        // Busca la vacante por su ID. Si no la encuentra, aborta con 404.
        // Puedes añadir condiciones adicionales si solo quieres mostrar vacantes activas, por ejemplo.
        // <<<< CORRECCIÓN: Usar la clase de modelo con el nombre correcto (Vacantes) >>>>
        $vacante = Vacantes::findOrFail($id); // Usar "Vacantes::findOrFail()"
        // O Vacantes::where('idVacantes', $id)->where('estado', 'activa')->firstOrFail(); // <<<< Si la clave primaria es idVacantes y filtras

        // Retorna la vacante como una respuesta JSON.
        return response()->json($vacante);
    }

    // No necesitarás métodos como store, update, destroy en un controlador para el usuario público.
}