<?php

namespace App\Http\Controllers\Api; // *** Verifica que este Namespace es correcto ***

use App\Http\Controllers\Controller;
use App\Models\Vacantes; // *** Asegúrate de que este 'use' apunta a tu modelo Vacantes ***
use Illuminate\Http\Request;
use Illuminate\Http\Response; // Para usar constantes de respuesta HTTP
use Illuminate\Support\Facades\Validator;

class vacantesController extends Controller // *** Asegúrate de que el nombre de la clase es EXACTAMENTE vacantesController ***
{
    /**
     * Display a listing of the resource.
     * GET /api/gestion
     * (Corresponde a vacanteService.getVacantes() - Espera un array de Vacantes)
     */
    public function index()
    {
        // Obtiene todas las vacantes
        $vacantes = Vacantes::all();

        // *** Modificado: Devuelve el array de vacantes DIRECTAMENTE con estado 200 OK ***
        return response()->json($vacantes, Response::HTTP_OK); // Código 200
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/gestion
     * (Corresponde a vacanteService.createVacante() - Espera el objeto Vacante creado)
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada (Ajusta las reglas a tus necesidades REALES)
        $validator = Validator::make($request->all(), [
            'nomVacante' => 'required|string|max:30',
            'descripVacante' => 'nullable|string', // Ajusta si no es nullable
            'salario' => 'nullable|numeric',       // Ajusta si no es nullable o es integer
            'expMinima' => 'nullable|string|max:45',
            'cargoVacante' => 'nullable|string|max:45',
            'catVacId' => 'nullable|integer',      // Ajusta si no es nullable o es required
            // Asegúrate de incluir validación para CUALQUIER otro campo que tu front-end envíe al crear/editar
        ]);

        if ($validator->fails()) {
            // *** Modificado: Devuelve un objeto de error estándar con estado 400 Bad Request ***
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST); // Código 400
        }

        try {
            // Crea una nueva instancia de Vacante. Asegúrate de que $fillable está bien en el Modelo.
            $vacante = Vacantes::create($request->all()); // Usa $request->all() si $fillable/guarded está bien

            // *** Modificado: Devuelve la vacante creada DIRECTAMENTE con estado 201 Created ***
            return response()->json($vacante, Response::HTTP_CREATED); // Código 201

        } catch (\Exception $e) {
             // *** Modificado: Devuelve un objeto de error estándar con estado 500 Internal Server Error ***
            return response()->json([
                'message' => 'Error interno del servidor al crear la vacante',
                'error' => $e->getMessage() // No muestres detalles sensibles del error en producción
            ], Response::HTTP_INTERNAL_SERVER_ERROR); // Código 500
        }
    }

    /**
     * Display the specified resource.
     * GET /api/gestion/{id}
     * (Tu front-end no lo usa, pero lo corregimos por si acaso)
     */
    // Recibes el ID como parámetro simple
    public function show($id) // Puedes cambiar el nombre del parámetro a $idVacantes si prefieres
    {
        // Busca la vacante por su clave primaria (idVacantes)
        $vacante = Vacantes::find($id); // Usa find() con el ID

        if ($vacante) {
            // *** Modificado: Devuelve la vacante encontrada DIRECTAMENTE con estado 200 OK ***
            return response()->json($vacante, Response::HTTP_OK); // Código 200
        } else {
            // *** Modificado: Devuelve un mensaje de error estándar con estado 404 Not Found ***
            return response()->json(['message' => 'Vacante no encontrada'], Response::HTTP_NOT_FOUND); // Código 404
        }
    }

    /**
     * Update the specified resource in storage.
     * PUT /api/gestion/{id}
     * (Corresponde a vacanteService.updateVacante(vacante) - Espera el objeto Vacante actualizado)
     */
    // Recibes el ID como parámetro simple
    public function update(Request $request, $id) // Puedes cambiar el nombre del parámetro $id a $idVacantes si prefieres
    {
        // Busca la vacante por su clave primaria (idVacantes)
        $vacante = Vacantes::find($id); // Usa find() con el ID

        if (!$vacante) {
             // *** Modificado: Devuelve un mensaje de error estándar con estado 404 Not Found ***
            return response()->json(['message' => 'Vacante no encontrada'], Response::HTTP_NOT_FOUND); // Código 404
        }

        // Validar los datos de entrada (Ajusta reglas, pueden ser diferentes a store si campos no son required al actualizar)
        $validator = Validator::make($request->all(), [
            'nomVacante' => 'required|string|max:30', // Ajusta validación
            'descripVacante' => 'nullable|string',
            'salario' => 'nullable|numeric',
             // ... otras reglas ...
        ]);

        if ($validator->fails()) {
            // *** Modificado: Devuelve un objeto de error estándar con estado 400 Bad Request ***
             return response()->json([
                 'message' => 'Error de validación',
                 'errors' => $validator->errors()
             ], Response::HTTP_BAD_REQUEST); // Código 400
        }

        try {
            // Actualiza la instancia de Vacante. Usa $request->all() si $fillable/guarded está bien.
            // Si no usas $request->all(), tendrías que asignar campo por campo como tenías antes:
            // $vacante->nomVacante = $request->nomVacante;
            // $vacante->descripVacante = $request->descripVacante;
            // ... y luego $vacante->save();
             $vacante->update($request->all()); // Usa update() si $fillable/guarded está bien

            // *** Modificado: Devuelve la vacante actualizada DIRECTAMENTE con estado 200 OK ***
            return response()->json($vacante, Response::HTTP_OK); // Código 200

        } catch (\Exception $e) {
            // *** Modificado: Devuelve un objeto de error estándar con estado 500 Internal Server Error ***
             return response()->json([
                 'message' => 'Error interno del servidor al actualizar la vacante',
                 'error' => $e->getMessage() // No muestres detalles sensibles del error en producción
             ], Response::HTTP_INTERNAL_SERVER_ERROR); // Código 500
        }
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/gestion/{id}
     * (Corresponde a vacanteService.deleteVacante(id) - Espera respuesta vacía 204)
     */
    // Recibes el ID como parámetro simple
    public function destroy($id) // Puedes cambiar el nombre del parámetro $id a $idVacantes si prefieres
    {
        // Busca la vacante por su clave primaria (idVacantes)
        $vacante = Vacantes::find($id); // Usa find() con el ID

        if (!$vacante) {
             // *** Modificado: Devuelve un mensaje de error estándar con estado 404 Not Found ***
            return response()->json(['message' => 'Vacante no encontrada'], Response::HTTP_NOT_FOUND); // Código 404
        }

        try {
            // Elimina la instancia de Vacante
            $vacante->delete();

            // *** Modificado: Devuelve respuesta vacía con estado 204 No Content ***
            return response()->json(null, Response::HTTP_NO_CONTENT); // Código 204

        } catch (\Exception $e) {
            // *** Modificado: Devuelve un objeto de error estándar con estado 500 Internal Server Error ***
            return response()->json([
                'message' => 'Error interno del servidor al eliminar la vacante',
                'error' => $e->getMessage() // No muestres detalles sensibles del error en producción
            ], Response::HTTP_INTERNAL_SERVER_ERROR); // Código 500
        }
    }

    // *** Eliminado: Método updatePartial, no necesario para la implementación actual del front-end con PUT ***
    // public function updatePartial(Request $request, $id) { ... }
}