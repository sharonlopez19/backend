<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hojasvida;
use Illuminate\Support\Facades\Validator;

class hojasvidaController extends Controller
{
    public function index()
    {
        $Hojasvidas = Hojasvida::all();
        $data = [
            "rol" => $Hojasvidas,
            "status" => 200
        ];
        return response()->json($data, 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "claseLibretaMilitar" => "required|max:45",
            "numeroLibretaMilitar" => "required|max:45",
            "usuarioNumDocumento" => "required|number"
        ]);

        if ($validator->fails()) {
            $data = [
                "mensaje" => "Error en la validación de Hojas de vida",
                "errors" => $validator->errors(),
                "status" => 400
            ];
            return response()->json($data, 400); // ✅ sin los corchetes extra
        }

        try {
            $Hojasvida = Hojasvida::create([
                "claseLibretaMilitar" => $request->claseLibretaMilitar,
                "numeroLibretaMilitar" => $request->numeroLibretaMilitar,
                "usuarioNumDocumento " => $request->usuarioNumDocumento
            ]);

            return response()->json([
                "mensaje" => "Hoja de vida creada correctamente",
                "Hojasvida" => $Hojasvida,
                "status" => 201
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "mensaje" => "Error al crear el género",
                "error" => $e->getMessage(),
                "status" => 500
            ], 500);
        }
    }

    public function show($id)
    {
        $Hojasvida = Hojasvida::find($id);
        if (!$Hojasvida) {
            $data = [
                "mensage" => " No se encontro Hojasvida",
                "status" => 201
            ];
            return response()->json([$data], 201);
        }
        $data = [
            "rol" => $Hojasvida,
            "status" => 200
        ];
        return response()->json([$data], 200);
    }
    public function destroy($id)
    {
        $Hojasvida = Hojasvida::find($id);
        if (!$Hojasvida) {
            $data = [
                "mensage" => " No se encontro Hoja de vida",
                "status" => 404
            ];
            return response()->json([$data], 404);
        }
        $Hojasvida->delete();
        $data = [
            "rol" => 'Hoja de vida eliminada',
            "status" => 200
        ];
        return response()->json([$data], 200);
    }
    public function update(Request $request, $id)
    {
        $Hojasvida = Hojasvida::find($id);
        if (!$Hojasvida) {
            $data = [
                "mensage" => " No se encontro Hoja de vida",
                "status" => 404
            ];
            return response()->json([$data], 404);
        }
        $validator = Validator::make($request->all(), [
            "claseLibretaMilitar" => $request->claseLibretaMilitar,
            "numeroLibretaMilitar" => $request->numeroLibretaMilitar,
            "usuarioNumDocumento " => $request->usuarioNumDocumento
        ]);
        if ($validator->fails()) {
            $data = [
                "errors" => $validator->errors(),
                "status" => 400
            ];
            return response()->json([$data], 400);
        }
        $Hojasvida->claseLibretaMilitar = $request->claseLibretaMilitar;
        $Hojasvida->numeroLibretaMilitar = $request->numeroLibretaMilitar;
        $Hojasvida->usuarioNumDocumento = $request->usuarioNumDocumento;
        try {
            $Hojasvida->save();
            $data = [
                "hojasvida" => $Hojasvida,
                "status" => 200
            ];
            return response()->json([$data], 200);
        } catch (\Exception $e) {
            return response()->json([
                "mensaje" => "Error al modificar la hoja de vida",
                "error" => $e->getMessage(),
                "status" => 500
            ], 500);
        }
    }
    public function updatePartial(Request $request, $id)
    {
        $Hojasvida = Hojasvida::find($id);
        if (!$Hojasvida) {
            $data = [
                "mensage" => " No se encontro rol",
                "status" => 404
            ];
            return response()->json([$data], 404);
        }
        $validator = Validator::make($request->all(), [
            "claseLibretaMilitar" => "max:45",
            "numeroLibretaMilitar" => "max:45",
            "usuarioNumDocumento" => "number"
        ]);
        if ($validator->fails()) {
            $data = [
                "mesaje " => "Error al validar Hoja de vida",
                "errors" => $validator->errors(),
                "status" => 400
            ];
            return response()->json([$data], 400);
        }
        if ($request->has("idHojaDeVida")) {
            $Hojasvida->idHojasvida = $request->idHojasvida;
        }
        if ($request->has("claseLibretaMilitar")) {
            $Hojasvida->claseLibretaMilitar = $request->claseLibretaMilitar;
        }
        if ($request->has("numeroLibretaMilitar")) {
            $Hojasvida->numeroLibretaMilitar = $request->numeroLibretaMilitar;
        }
        if ($request->has("usuarioNumDocumento")) {
            $Hojasvida->usuarioNumDocumento = $request->usuarioNumDocumento;
        }
        $Hojasvida->save();
        $data = [
            "rol" => $Hojasvida,
            "status" => 200
        ];
        return response()->json([$data], 200);
    }
}
