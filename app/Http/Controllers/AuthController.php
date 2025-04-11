<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Registrar un nuevo usuario y devolver token JWT
    public function register(Request $request)
    {
        // Validación de campos incluyendo confirmaciones
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|confirmed|unique:users,email',
            'email_confirmation' => 'required|string|email',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
        ]);

        // En caso de error en validación
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en el registro.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Aquí puedes acceder directamente a los campos de confirmación
        $email = $request->email;
        $email_confirmation = $request->email_confirmation;
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;

        // Solo por seguridad, puedes comprobar que coincidan (opcional si ya validaste)
        if ($email !== $email_confirmation || $password !== $password_confirmation) {
            return response()->json([
                'message' => 'Los campos de confirmación no coinciden.'
            ], 422);
        }

        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        // Generar el token JWT
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Usuario registrado correctamente 🎉',
            'token' => $token,
            'user' => $user,
            'redirect' => '/home'
        ], 201);
    }

    // Iniciar sesión y devolver token
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        return response()->json([
            'token' => $token,
            'redirect' => '/home'
        ]);
    }

    // Obtener datos del usuario autenticado
    public function me()
    {
        return response()->json(Auth::user());
    }
}
