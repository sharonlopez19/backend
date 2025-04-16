<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\CategoriaVacantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class categoriaVacantesController extends Controller
{
    public function index()
    {
        $categoriaVacantes=CategoriaVacantes::all();
        $data=[
            "categoriaVacantes" => $categoriaVacantes,
            "status" => 200
        ];
        return response()->json($data,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomCategoria' => 'required|string|max:45',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'mensaje' => 'Error en la validación de datos de la categoria de vacantes',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }
    
        try {
            $categoriaVacantes = CategoriaVacantes::create([
                'nomCategoria' => $request->nomCategoria,
                
            ]);
    
            return response()->json([
                'mensaje' => 'categoria de vacante creada correctamente',
                'categoriaVacantes' => $categoriaVacantes,
                'status' => 201
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al crear el categoria de vacante',
                'error' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
        
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categoriaVacantes=CategoriaVacantes::find($id);
        $data=[
            "categoriaVacantes" => $categoriaVacantes,
            "status" => 200
        ];
        return response()->json($data,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function destroy($id)
    {
        $incapacidad = CategoriaVacantes::find($id);
        if (!$incapacidad) {
            $data = [
                "mensage" => " No se encontro la categoria de la vacante",
                "status" => 404
            ];
            return response()->json([$data], 404);
        }
        $incapacidad->delete();
        $data = [
            "categoriaVacantes:" => 'Categoria de vacante eliminado',
            "status" => 200
        ];
        return response()->json([$data], 200);
    }
    public function update(Request $request, $id)
    {
        $categoriaVacantes = CategoriaVacantes::find($id);
        if (!$categoriaVacantes) {
            $data = [
                "mensage" => " No se encontro la categoria de la vacante",
                "status" => 404
            ];
            return response()->json([$data], 404);
        }
        $validator = Validator::make($request->all(), [
            'nomCategoria' => 'required|string|max:50',
        ]);
        if ($validator->fails()) {
            $data = [
                "errors" => $validator->errors(),
                "status" => 400
            ];
            return response()->json([$data], 400);
        }
        $categoriaVacantes->nomCategoria = $request->nomCategoria;


        try {
            $categoriaVacantes->save();
            $data = [
                "categoriaVacantes" => $categoriaVacantes,
                "status" => 200
            ];
            return response()->json([$data], 200);
        } catch (\Exception $e) {
            return response()->json([
                "mensaje" => "Error al modificar la categoria de la vacante",
                "error" => $e->getMessage(),
                "status" => 500
            ], 500);
        }
    }
    public function updatePartial(Request $request, $id)
    {
        $categoriaVacantes = CategoriaVacantes::find($id);
        if (!$categoriaVacantes) {
            $data = [
                "mensage" => " No se encontro la categoria de la vacante",
                "status" => 404
            ];
            return response()->json([$data], 404);
        }
        $validator = Validator::make($request->all(), [
            'nomCategoria' => 'required|string|max:50',
        ]);
        if ($validator->fails()) {
            $data = [
                "mesaje " => "Error al validar la categoria de la vacante",
                "errors" => $validator->errors(),
                "status" => 400
            ];
            return response()->json([$data], 400);
        }
        if ($request->has("nomCategoria")) {
            $categoriaVacantes->nomCategoria = $request->nomCategoria;
        }
        
        
        $categoriaVacantes->save();
        $data = [
            "categoriaVacantes:" => $categoriaVacantes,
            "status" => 200
        ];
        return response()->json([$data], 200);
    }

}
