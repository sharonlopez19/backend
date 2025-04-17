<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Contrato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class contratoController extends Controller
{

    public function index()
    {
        $contrato=Contrato::all();
        $data=[
            "contrato" => $contrato,
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
            'estado' => 'required|integer',
            'fechaIngreso' => 'required|date',
            'fechaFinal'=>'required|date',
            'documento' => 'required|string|max:100',
            'tipoContratoId' => 'required',
            'numDocumento'=> 'required'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'mensaje' => 'Error en la validación de datos de contrato',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }
    
        try {
            $contrato = Contrato::create([
                'estado' => $request->estado,
                'fechaIngreso' => $request->fechaIngreso,
                'fechaFinal' => $request->fechaFinal,
                'documento' => $request->documento,
                'tipoContratoId' => $request->tipoContratoId,
                'numDocumento' => $request->numDocumento,
                
            ]);
    
            return response()->json([
                'mensaje' => 'Contrato creado correctamente',
                'contrato' => $contrato,
                'status' => 201
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al crear el contrato',
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
        $contrato=Contrato::find($id);
        $data=[
            "contrato" => $contrato,
            "status" => 200
        ];
        return response()->json($data,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function destroy($id)
    {
        $contrato = Contrato::find($id);
        if (!$contrato) {
            $data = [
                "mensage" => " No se encontro el contrato",
                "status" => 404
            ];
            return response()->json([$data], 404);
        }
        $contrato->delete();
        $data = [
            "contrato:" => 'Contrato eliminado',
            "status" => 200
        ];
        return response()->json([$data], 200);
    }
    public function update(Request $request, $id)
    {
        $contrato = Contrato::find($id);
        if (!$contrato) {
            $data = [
                "mensage" => " No se encontro el contrato",
                "status" => 404
            ];
            return response()->json([$data], 404);
        }
        $validator = Validator::make($request->all(), [
            'estado' => 'required|integer',
            'fechaIngreso' => 'required|date',
            'fechaFinal'=>'required|date',
            'documento' => 'required|string|max:100',
            'tipoContratoId' => 'required',
            'numDocumento'=> 'required'
        ]);
        if ($validator->fails()) {
            $data = [
                "errors" => $validator->errors(),
                "status" => 400
            ];
            return response()->json([$data], 400);
        }

                $contrato->estado = $request->estado;
                $contrato->fechaIngreso = $request->fechaIngreso;
                $contrato->fechaFinal = $request->fechaFinal;
                $contrato->documento = $request->documento;
                $contrato->tipoContratoId = $request->tipoContratoId;
                $contrato->numDocumento = $request->numDocumento;

        try {
            $contrato->save();
            $data = [
                "contrato" => $contrato,
                "status" => 200
            ];
            return response()->json([$data], 200);
        } catch (\Exception $e) {
            return response()->json([
                "mensaje" => "Error al modificar el contrato",
                "error" => $e->getMessage(),
                "status" => 500
            ], 500);
        }
    }
    public function updatePartial(Request $request, $id)
    {
        $contrato = Contrato::find($id);
        if (!$contrato) {
            $data = [
                "mensage" => " No se encontro el contrato",
                "status" => 404
            ];
            return response()->json([$data], 404);
        }
        $validator = Validator::make($request->all(), [
            'estado' => 'integer',
            'fechaIngreso' => 'date',
            'fechaFinal'=>'date',
            'documento' => 'string|max:100',
            'tipoContratoId' => 'integer',
            'numDocumento'=> 'integer'
        ]);
        if ($validator->fails()) {
            $data = [
                "mesaje " => "Error al validar el contrato",
                "errors" => $validator->errors(),
                "status" => 400
            ];
            return response()->json([$data], 400);
        }

        if ($request->has("estado")) {
            $contrato->estado = $request->estado;
        }

        if ($request->has("fechaIngreso")) {
            $contrato->fechaIngreso = $request->fechaIngreso;
        }

        if ($request->has("fechaFinal")) {
            $contrato->fechaFinal = $request->fechaFinal;
        }
        
        if ($request->has("documento")) {
            $contrato->documento = $request->documento;
        }

        if ($request->has("tipoContratoId")) {
            $contrato->tipoContratoId = $request->tipoContratoId;
        }

        if ($request->has("numDocumento")) {
            $contrato->numDocumento = $request->numDocumento;
        }
        
        
        
        $contrato->save();
        $data = [
            "contrato:" => $contrato,
            "status" => 200
        ];
        return response()->json([$data], 200);
    }
}
