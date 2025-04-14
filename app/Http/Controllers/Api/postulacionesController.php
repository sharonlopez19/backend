<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Postulaciones;
use Illuminate\Support\Facades\Validator;

class postulacionesController extends Controller
{
    public function index()
    {
        $postulaciones = Postulaciones::all();
        if (!$postulaciones) {
            return response()->json([
                'mensaje' => 'No retorna por error en DB',
                'errors' => $postulaciones->errors(),
                'status' => 400
            ], 400);
        } else {

            $data = [
                "permisos" => $postulaciones,
                "status" => 200
            ];
            return response()->json($data, 200);
        }
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
            
            'fechaPostulacion' => 'required|date',
            'estado' => 'required|integer',
            'vacantesId' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'mensaje' => 'Error en la validación de datos de permisos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        try {


            $postulaciones = Postulaciones::create([
                
                'fechaPostulacion' => $request->fechaPostulacion,
                'estado' => $request->estado,
                'vacantesId' => $request->vacantesId

            ]);

            return response()->json([
                'mensaje' => 'postulacion creada correctamente',
                'permisos' => $postulaciones,
                'status' => 201
            ], 201);


        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al crear el usuariohasrol',
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
        $user = Postulaciones::find($id);
        if ($user) {
            $data = [
                "permisos" => $user,
                "status" => 200
            ];
            return response()->json($data, 200);
        } else {
            return response()->json([
                'mensaje' => 'El usuario no existe',
                'status' => 400
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function destroy($id)
    {

        $postulaciones = Postulaciones::find($id);
        if (!$postulaciones) {
            $data = [
                "mensage" => " No se encontro permisos",
                "status" => 404
            ];
            return response()->json([$data], 404);
        } else {
            $postulaciones->delete();
            $data = [
                "permisos" => 'usuariohasrol eliminado',
                "status" => 200
            ];
            return response()->json([$data], 200);
        }

    }
    public function update(Request $request, $id)
    {
        $postulaciones = Postulaciones::find($id);
        if (!$postulaciones) {
            $data = [
                "mensage" => " No se encontro permisos",
                "status" => 404
            ];
            return response()->json([$data], 404);
        } else {

            $validator = Validator::make($request->all(), [
                
                'fechaPostulacion' => 'required|date',
                'estado' => 'required|integer',
                'vacantesId' => 'required|integer',
                
            ]);
            if ($validator->fails()) {
                $data = [
                    "errors" => $validator->errors(),
                    "status" => 400
                ];
                return response()->json([$data], 400);
            }

           
            $postulaciones->fechaPostulacion = $request->fechaPostulacion;
            $postulaciones->estado = $request->estado;
            $postulaciones->vacantesId = $request->vacantesId;

            try {
                $postulaciones->save();
                $data = [
                    "permisos" => $postulaciones,
                    "status" => 200
                ];
                return response()->json([$data], 200);
            } catch (\Exception $e) {
                return response()->json([
                    "mensaje" => "Error al modificar el usuario has rol",
                    "error" => $e->getMessage(),
                    "status" => 500
                ], 500);
            }
        }
    }
    public function updatePartial(Request $request, $id)
    {
        $postulaciones = Postulaciones::find($id);
        if (!$postulaciones) {
            $data = [
                "mensage" => " No se encontro postulacion",
                "status" => 404
            ];
            return response()->json([$data], 404);
        } else {

            $validator = Validator::make($request->all(), [

                'fechaPostulacion' => 'date',
                'estado' => 'integer',
                'vacantesId' => 'integer'
            ]);
            if ($validator->fails()) {
                $data = [
                    "mesaje " => "Error al validar vacantes",
                    "errors" => $validator->errors(),
                    "status" => 400
                ];
                return response()->json([$data], 400);
            }
            
            $postulaciones->fechaPostulacion = $request->fechaPostulacion;
            $postulaciones->estado = $request->estado;
            $postulaciones->vacantesId = $request->vacantesId;

            if ($request->has("estado")) {
                $postulaciones->estado = $request->estado;
            }
            if ($request->has("fechaPostulacion")) {
                $postulaciones->fechaPostulacion = $request->fechaPostulacion;
            }
            
            if ($request->has("vacantesId")) {
                $postulaciones->vacantesId = $request->vacantesId;
            }
            


            $postulaciones->save();
            $data = [
                "permisos" => $postulaciones,
                "status" => 200
            ];
            return response()->json([$data], 200);
        }
    }
}
