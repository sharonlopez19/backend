<?php

// Namespace del controlador, asumiendo que está en app/Http/Controllers/Api
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; // Clase base Controller
use Illuminate\Http\Request;
use App\Models\CategoriaVacantes; // <-- ¡MODELO CORREGIDO!
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

// Nombre de la clase del controlador
// Basado en el error fatal "App\Http\Controllers\Api\CategoriaVacantes"
// y las indicaciones anteriores, la clase del controlador parece ser CategoriaVacantes.
class CategoriaVacantesController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/categoriavacantes
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // === ¡Usa el modelo correcto! ===
            $categorias = CategoriaVacantes::all(); // <-- ¡MODELO CORREGIDO EN USO!

            return response()->json([
                'categoriavacantes' => $categorias
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al obtener categorías de vacantes (Api\CategoriaVacantes::index): ' . $e->getMessage());
            return response()->json(['message' => 'Ocurrió un error al obtener las categorías.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/categoriavacantes
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomCategoria' => 'required|string|max:45|unique:categoriavacantes,nomCategoria',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error de validación', 'errors' => $validator->errors()], 400);
        }

        try {
            // === ¡Usa el modelo correcto! ===
            $categoria = new CategoriaVacantes(); // <-- ¡MODELO CORREGIDO EN USO!
            $categoria->nomCategoria = $request->nomCategoria;
            $categoria->save();

            return response()->json(['message' => 'Categoría creada con éxito', 'categoria' => $categoria], 201);

        } catch (\Exception $e) {
             Log::error('Error al crear categoría de vacantes (Api\CategoriaVacantes::store): ' . $e->getMessage());
            return response()->json(['message' => 'Ocurrió un error al crear la categoría.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     * GET /api/categoriavacantes/{id}
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            // === ¡Usa el modelo correcto! ===
            // Asegúrate que primaryKey es 'idCatVac' en el modelo CategoriaVacantes
            $categoria = CategoriaVacantes::find($id); // <-- ¡MODELO CORREGIDO EN USO!

            if (!$categoria) {
                return response()->json(['message' => 'Categoría no encontrada'], 404);
            }

            return response()->json($categoria, 200);

        } catch (\Exception $e) {
             Log::error('Error al obtener categoría de vacantes con ID ' . $id . ' (Api\CategoriaVacantes::show): ' . $e->getMessage());
            return response()->json(['message' => 'Ocurrió un error al obtener la categoría.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     * PUT /api/categoriavacantes/{id}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // === ¡Usa el modelo correcto! ===
        $categoria = CategoriaVacantes::find($id); // <-- ¡MODELO CORREGIDO EN USO!

        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nomCategoria' => [
                'required',
                'string',
                'max:45',
                Rule::unique('categoriavacantes', 'nomCategoria')->ignore($categoria->idCatVac, 'idCatVac'),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error de validación', 'errors' => $validator->errors()], 400);
        }

        try {
            $categoria->nomCategoria = $request->nomCategoria;
            $categoria->save();

            return response()->json(['message' => 'Categoría actualizada con éxito', 'categoria' => $categoria], 200);

        } catch (\Exception $e) {
            Log::error('Error al actualizar categoría de vacantes con ID ' . $id . ' (Api\CategoriaVacantes::update): ' . $e->getMessage());
            return response()->json(['message' => 'Ocurrió un error al actualizar la categoría.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/categoriavacantes/{id}
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
         // === ¡Usa el modelo correcto! ===
        $categoria = CategoriaVacantes::find($id); // <-- ¡MODELO CORREGIDO EN USO!

        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        try {
            $categoria->delete();

            return response()->json(['message' => 'Categoría eliminada con éxito'], 200);

        } catch (\Exception $e) {
            Log::error('Error al eliminar categoría de vacantes con ID ' . $id . ' (Api\CategoriaVacantes::destroy): ' . $e->getMessage());
             if ($e instanceof \Illuminate\Database\QueryException && $e->getCode() === '23000') {
                 return response()->json(['message' => 'No se puede eliminar la categoría porque está asociada a vacantes existentes.'], 409);
             }
            return response()->json(['message' => 'Ocurrió un error al eliminar la categoría.', 'error' => $e->getMessage()], 500);
        }
    }

    // updatePartial method remains commented out unless needed for PATCH
}