<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    /**
     * Registrar un nuevo usuario y devolver token JWT.
     */
    public function register(Request $request)
    {
        // Validar los datos del usuario
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|confirmed|unique:users,email',
            'email_confirmation' => 'required|string|email',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
            'rol' => 'required|integer|in:1,2,3,4,5', // Ajustar según los valores permitidos
        ]);

        // Retornar errores de validación
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en el registro.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
        ]);

        // Generar un token JWT para el usuario
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Usuario registrado correctamente 🎉',
            'token' => $token,
            'user' => $user,
            'redirect' => '/directorio'
        ], 201);
    }

    /**
     * Iniciar sesión y devolver token JWT.
     */
    public function login(Request $request)
    {
        // Extraer las credenciales del request
        $credentials = $request->only('email', 'password');

        // Registrar logs para depuración
        Log::info('Intento de login', ['email' => $request->email ?? 'Correo no proporcionado']);

        // Intentar autenticar al usuario
        if (!$token = JWTAuth::attempt($credentials)) {
            Log::error('Error en login: credenciales incorrectas', ['email' => $request->email ?? 'Correo no proporcionado']);
            return response()->json(['error' => 'Correo o contraseña incorrectos'], 401);
        }

        // Obtener el usuario autenticado
        $user = JWTAuth::user();

        // Responder con token y datos de usuario
        return response()->json([
            'user' => $user,
            'token' => $token,
            'redirect' => '/directorio' // Ruta de redirección
        ]);
    }

    /**
     * Retornar los datos del usuario autenticado.
     */
    public function me()
    {
        return response()->json([
            'message' => 'Usuario autenticado con éxito',
            'user' => Auth::user()
        ]);
    }
}
