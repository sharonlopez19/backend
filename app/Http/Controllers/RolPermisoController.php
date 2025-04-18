<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use Illuminate\Http\Request;

class RolPermisoController extends Controller
{
    public function asignarPermisos(Request $request, $rolId)
    {
        $rol = Rol::findOrFail($rolId);
        $rol->permisos()->sync($request->permiso_ids); // Array de IDs de permisos

        return response()->json([
            'message' => 'Permisos asignados correctamente.',
            'permisos' => $rol->permisos
        ]);
    }

    public function obtenerPermisos($rolId)
    {
        $rol = Rol::with('permisos')->findOrFail($rolId);
        return response()->json($rol->permisos);
    }
}

