<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Vacantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class vacantesController extends Controller
{
    public function index()
    {
        $vacantes=Vacantes::all();
        $data=[
            "vacantes" => $vacantes,
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
            'nomVacante' => 'required|string|max:30',
            'descripVacante' => 'required|string',
            'salario'=>'required',
            'expMinima' => 'required|string|max:45',
            'cargoVacante' => 'required|string|max:45',
            'catVacId'=> 'required|integer'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'mensaje' => 'Error en la validación de datos de vacantes',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }
    
        try {
            $vacantes = Vacantes::create([
                'nomVacante' => $request->nomVacante,
                'descripVacante' => $request->descripVacante,
                'salario' => $request->salario,
                'expMinima' => $request->expMinima,
                'cargoVacante' => $request->cargoVacante,
                'catVacId' => $request->catVacId,
                
            ]);
    
            return response()->json([
                'mensaje' => 'vacante creada correctamente',
                'vacantes' => $vacantes,
                'status' => 201
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al crear la vacante',
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
        $vacantes=Vacantes::find($id);
        $data=[
            "vacantes" => $vacantes,
            "status" => 200
        ];
        return response()->json($data,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function destroy($id)
    {
        $vacantes = Vacantes::find($id);
        if (!$vacantes) {
            $data = [
                "mensage" => " No se encontro la vacante",
                "status" => 404
            ];
            return response()->json([$data], 404);
        }
        $vacantes->delete();
        $data = [
            "vacantes:" => 'Vacante eliminada',
            "status" => 200
        ];
        return response()->json([$data], 200);
    }
    public function update(Request $request, $id)
    {
        $vacantes = Vacantes::find($id);
        if (!$vacantes) {
            $data = [
                "mensage" => " No se encontro la vacante",
                "status" => 404
            ];
            return response()->json([$data], 404);
        }
        $validator = Validator::make($request->all(), [
            'nomVacante' => 'required|string|max:30',
            'descripVacante' => 'required|string',
            'salario'=>'required',
            'expMinima' => 'required|string|max:45',
            'cargoVacante' => 'required|string|max:45',
            'catVacId'=> 'required|integer'
        ]);
        if ($validator->fails()) {
            $data = [
                "errors" => $validator->errors(),
                "status" => 400
            ];
            return response()->json([$data], 400);
        }
                $vacantes->nomVacante = $request->nomVacante;
                $vacantes->descripVacante = $request->descripVacante;
                $vacantes->salario = $request->salario;
                $vacantes->expMinima = $request->expMinima;
                $vacantes->cargoVacante = $request->cargoVacante;
                $vacantes->catVacId = $request->catVacId;


        try {
            $vacantes->save();
            $data = [
                "vacantes" => $vacantes,
                "status" => 200
            ];
            return response()->json([$data], 200);
        } catch (\Exception $e) {
            return response()->json([
                "mensaje" => "Error al modificar la vacante",
                "error" => $e->getMessage(),
                "status" => 500
            ], 500);
        }
    }
    public function updatePartial(Request $request, $id)
    {
        $vacantes = Vacantes::find($id);
        if (!$vacantes) {
            $data = [
                "mensage" => " No se encontro la vacante",
                "status" => 404
            ];
            return response()->json([$data], 404);
        }
        $validator = Validator::make($request->all(), [
            'nomVacante' => 'string|max:30',
            'descripVacante' => 'string',
            'salario'=>'float',
            'expMinima' => 'string|max:45',
            'cargoVacante' => 'string|max:45',
            'catVacId'=> 'integer'
        ]);
        if ($validator->fails()) {
            $data = [
                "mesaje " => "Error al validar la vacante",
                "errors" => $validator->errors(),
                "status" => 400
            ];
            return response()->json([$data], 400);
        }

        if ($request->has("nomVacante")) {
            $vacantes->nomVacante = $request->nomVacante;
        }
        if ($request->has("descripVacante")) {
            $vacantes->descripVacante = $request->descripVacante;
        }
        if ($request->has("salario")) {
            $vacantes->salario = $request->salario;
        }
        if ($request->has("expMinima")) {
            $vacantes->expMinima = $request->expMinima;
        }
        if ($request->has("cargoVacante")) {
            $vacantes->cargoVacante = $request->cargoVacante;
        }
        if ($request->has("catVacId")) {
            $vacantes->catVacId = $request->catVacId;
        }
        
        
        
        $vacantes->save();
        $data = [
            "vacantes:" => $vacantes,
            "status" => 200
        ];
        return response()->json([$data], 200);
    }

}
