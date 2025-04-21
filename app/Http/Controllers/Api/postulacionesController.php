<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Postulaciones;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class PostulacionesController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Postulaciones::query();

            if ($request->has('vacantesId')) {
                $query->where('vacantesId', $request->input('vacantesId'));
            }

            $postulaciones = $query->get();

            return response()->json([
                'data' => $postulaciones
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al obtener lista de postulaciones (Api\PostulacionesController::index): ' . $e->getMessage());
            return response()->json([
                'message' => 'Ocurrió un error al obtener las postulaciones.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($idPostulaciones)
    {
        try {
            $postulacion = Postulaciones::find($idPostulaciones);

            if (!$postulacion) {
                return response()->json(['message' => 'Postulación no encontrada'], 404);
            }

            return response()->json([
                'data' => $postulacion
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al obtener postulación con ID ' . $idPostulaciones . ' (Api\PostulacionesController::show): ' . $e->getMessage());
            return response()->json([
                'message' => 'Ocurrió un error al obtener la postulación.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // === MÉTODO CORREGIDO PARA RECIBIR ID COMO RUTA ===
    public function searchByVacantesId($vacantesId)
    {
        try {
            if (empty($vacantesId) || !is_numeric($vacantesId)) {
                return response()->json([
                    'message' => 'Parámetro vacantesId inválido o faltante.'
                ], 400);
            }

            $vacantesId = (int) $vacantesId;

            $postulaciones = Postulaciones::where('vacantesId', $vacantesId)->get();

            return response()->json([
                'results' => $postulaciones
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al buscar postulaciones por Vacante ID (Api\PostulacionesController::searchByVacantesId): ' . $e->getMessage());
            return response()->json([
                'message' => 'Ocurrió un error al realizar la búsqueda.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, $idPostulaciones)
    {
        try {
            $postulacion = Postulaciones::find($idPostulaciones);

            if (!$postulacion) {
                return response()->json(['message' => 'Postulación no encontrada'], 404);
            }

            $validator = Validator::make($request->all(), [
                'estado' => ['required', 'string', Rule::in(['Pendiente', 'Aceptado', 'Rechazado'])],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Error de validación del estado',
                    'errors' => $validator->errors()
                ], 400);
            }

            $nuevoEstadoString = $request->input('estado');
            $nuevoEstadoTinyint = $this->mapEstadoToTinyint($nuevoEstadoString);

            $postulacion->estado = $nuevoEstadoTinyint;
            $postulacion->save();

            return response()->json([
                'message' => 'Estado de postulación actualizado con éxito',
                'postulacion' => $postulacion
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar estado de postulación con ID ' . $idPostulaciones . ' (Api\PostulacionesController::updateStatus): ' . $e->getMessage());
            return response()->json([
                'message' => 'Ocurrió un error al actualizar el estado de la postulación.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function mapEstadoToTinyint(string $estadoString): int
    {
        switch ($estadoString) {
            case 'Aceptado': return 1;
            case 'Rechazado': return 2;
            case 'Pendiente':
            default: return 0;
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'vacantesId' => 'required|integer|exists:vacantes,idVacantes',
                'estado' => ['required', 'string', Rule::in(['Pendiente', 'Aceptado', 'Rechazado'])],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Errores de validación',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $estadoTinyint = $this->mapEstadoToTinyint($request->input('estado'));

            $postulacion = Postulaciones::create([
                'vacantesId' => $request->input('vacantesId'),
                'estado' => $estadoTinyint,
                'fechaPostulacion' => now()->toDateString(),
            ]);

            return response()->json([
                'message' => 'Postulación creada exitosamente',
                'data' => $postulacion,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al crear postulación (PostulacionesController::store): ' . $e->getMessage());
            return response()->json([
                'message' => 'Ocurrió un error al crear la postulación.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
