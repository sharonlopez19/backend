<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vacaciones;
use Illuminate\Support\Facades\Validator;

class vacacioneController extends Controller
{
    public function index()
    {
        $vacaciones=Vacaciones::all();
        $data=[
            "vacaciones:" => $vacaciones,
            "status" => 200
        ];
        return response()->json($data,200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'descrip' => 'required|string|max:500',
            'archivo' => 'required|string|max:50',
            'fechaInicio' => 'required|date',
            'fechaFinal' => 'required|date',
            'contratoId' => 'required|integer'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'mensaje' => 'Error en la validación de datos de la vacaciones:',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }
    
        try {
            $vacaciones = Vacaciones::create([
                'descrip' => $request->descrip,
                'archivo' => $request->archivo,
                'fechaInicio' => $request->fechaInicio,
                'fechaFinal' => $request->fechaFinal,
                'contratoId' => $request->contratoId
                
            ]);
    
            return response()->json([
                'mensaje' => 'vacaciones: creado correctamente',
                'vacaciones:' => $vacaciones,
                'status' => 201
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al crear el vacaciones:',
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
        $vacaciones=Vacaciones::find($id);
        $data=[
            "vacaciones:" => $vacaciones,
            "status" => 200
        ];
        return response()->json($data,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function destroy($id)
    {
        $vacaciones = Vacaciones::find($id);
        if (!$vacaciones) {
            $data = [
                "mensage" => " No se encontro vacaciones:",
                "status" => 404
            ];
            return response()->json([$data], 404);
        }
        $vacaciones->delete();
        $data = [
            "vacaciones:" => 'vacaciones: eliminado',
            "status" => 200
        ];
        return response()->json([$data], 200);
    }
    public function update(Request $request, $id)
    {
        $vacaciones = Vacaciones::find($id);
        if (!$vacaciones) {
            $data = [
                "mensage" => " No se encontro vacaciones:",
                "status" => 404
            ];
            return response()->json([$data], 404);
        }
        $validator = Validator::make($request->all(), [
            
            'descrip' => 'required|string|max:500',
            'archivo' => 'required|string|max:50',
            'fechaInicio' => 'required|date',
            'fechaFinal' => 'required|date',
            'contratoId' => 'required|integer'
        ]);
        if ($validator->fails()) {
            $data = [
                "errors" => $validator->errors(),
                "status" => 400
            ];
            return response()->json([$data], 400);
        }
        
        $vacaciones->descrip = $request->descrip;
        $vacaciones->archivo = $request->archivo;
        $vacaciones->fechaInicio = $request->fechaInicio;
        $vacaciones->fechaFinal = $request->fechaFinal;
        $vacaciones->contratoId = $request->contratoId;

        try {
            $vacaciones->save();
            $data = [
                "vacaciones:" => $vacaciones,
                "status" => 200
            ];
            return response()->json([$data], 200);
        } catch (\Exception $e) {
            return response()->json([
                "mensaje" => "Error al modificar la vacaciones:",
                "error" => $e->getMessage(),
                "status" => 500
            ], 500);
        }
    }
    public function updatePartial(Request $request, $id)
    {
        $vacaciones = Vacaciones::find($id);
        if (!$vacaciones) {
            $data = [
                "mensage" => " No se encontro vacaciones:",
                "status" => 404
            ];
            return response()->json([$data], 404);
        }
        $validator = Validator::make($request->all(), [
            
            'descrip' => 'string|max:500',
            'archivo' => 'string|max:50',
            'fechaInicio' => 'date',
            'fechaFinal' => 'date',
            'contratoId' => 'integer',
        ]);
        if ($validator->fails()) {
            $data = [
                "mesaje " => "Error al validar vacaciones:",
                "errors" => $validator->errors(),
                "status" => 400
            ];
            return response()->json([$data], 400);
        }
        if ($request->has("descrip")) {
            $vacaciones->descrip = $request->descrip;
        }
        if ($request->has("archivo")) {
            $vacaciones->archivo = $request->archivo;
        }
        if ($request->has("fechaInicio")) {
            $vacaciones->fechaInicio = $request->fechaInicio;
        }
        if ($request->has("fechaFinal")) {
            $vacaciones->fechaFinal = $request->fechaFinal;
        }
        if ($request->has("contratoId")) {
            $vacaciones->contratoId = $request->contratoId;
        }
        
        
        $vacaciones->save();
        $data = [
            "vacaciones:" => $vacaciones,
            "status" => 200
        ];
        return response()->json([$data], 200);
    }
}
