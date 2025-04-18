<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Registrar un nuevo usuario y devolver token JWT.
     */
    public function register(Request $request)
    {
        
        $dd = "";
        if ($dd == "SI") {
            // Validar campos, incluyendo confirmación de email y contraseña
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|confirmed|unique:users,email',
                'email_confirmation' => 'required|string|email',
                'password' => 'required|string|min:6|confirmed',
                'rol' => 'required',
                'password_confirmation' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Error en el registro.',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Validar coincidencia de confirmaciones manualmente (opcional)
            if (
                $request->email !== $request->email_confirmation ||
                $request->password !== $request->password_confirmation
            ) {
                return response()->json([
                    'message' => 'Los campos de confirmación no coinciden.'
                ], 422);
            }

            // Crear usuario (la contraseña se hashea automáticamente en el modelo)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password), // Usar bcrypt para hashear la contraseña
                'rol' => $request->rol
            ]);

            // Generar token JWT
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'message' => 'Usuario registrado correctamente 🎉',
                'token' => $token,
                'user' => $user,
                'redirect' => '/directorio' // Para redirigir desde Angular
            ], 201);
        } else {
            
            dd($request->all());
        }
    }

    /**
     * Iniciar sesión y devolver token JWT.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        //$user = User::where('email', $request->email)->first();
        // Intentar autenticar al usuario y obtener el token
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }
        $user = JWTAuth::user();
        return response()->json([
            'user' => $user,
            'token' => $token,
            'redirect' => '/directorio' // Redirigir desde Angular
        ]);
    }
    public function index()
    {
        $users = User::all();
        return response()->json([
            'user' => $users,


        ], 200);
    }

    /**
     * Retornar los datos del usuario autenticado.
     */
    public function me()
    {
        // Retorna los datos del usuario autenticado
        return response()->json(Auth::user());
    }
}
