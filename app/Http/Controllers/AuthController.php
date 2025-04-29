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
   
    public function register(Request $request)
    {
        // Validar campos, incluyendo confirmación de email y contraseña
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|confirmed|unique:users,email',
            'email_confirmation' => 'required|string|email',
            'password' => 'required|string|min:6|confirmed',
            'rol'=>'required',
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
            'rol'=> $request->rol
        ]);

        // Generar token JWT
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Usuario registrado correctamente 🎉',
            'token' => $token,
            'user' => $user,
            'redirect' => '/directorio' // Para redirigir desde Angular
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
    public function index()
    {
        $users = User::all();
        return response()->json([
            'user' => $users,


        ], 200);
    }
    public function show($id)
    {
        $user = User::find($id);
        $data = [
            "usuario" => $user,
            "status" => 200
        ];
        return response()->json($data, 200);
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
    public function destroy($id)
    {
        $usuario = User::find($id);
        if (!$usuario) {
            $data = [
                "mensage" => " No se encontro Usuario",
                "status" => 404
            ];
            return response()->json([$data], 404);
        }
        $usuario->delete();
        $data = [
            "rol" => 'Usuario eliminado',
            "status" => 200
        ];
        return response()->json([$data], 200);
    }
    // app/Http/Controllers/AuthController.php
    public function verificarExistencia(Request $request)
    {
        $email = $request->query('email');

        $existe = User::where('email', $email)->exists();

        return response()->json(['existe' => $existe]);
    }
    public function indexConRoles()
    {
        $usuarios = User::with('roles')->get();

        return response()->json([
            'status' => 200,
            'usuarios' => $usuarios
        ]);
    }
    public function updatePartial(Request $request, $id)
    {
        $usuario = User::find($id);
        if (!$usuario) {
            $data = [
                "mensage" => " No se encontro Usuario",
                "status" => 404
            ];
            return response()->json($data, 404);
        }
        $validator = Validator::make($request->all(), [

            'name' => 'string|max:255',
            'email' => 'string|max:255',
            'password' => 'string|max:255',
            'rol' => 'integer'
        ]);
        if ($validator->fails()) {
            $data = [
                "mesaje " => "Error al validar Users",
                "errors" => $validator->errors(),
                "status" => 400
            ];
            return response()->json($data, 400);
        }
        if ($request->has("name")) {
            $usuario->name = $request->name;
        }
        if ($request->has("email")) {
            $usuario->email = $request->email;
        }
        if ($request->has("password")) {
            $usuario->password = $request->password;
        }
        if ($request->has("rol")) {
            $usuario->rol = $request->rol;
        }
        
        $usuario->save();
        $data = [
            "rol" => $usuario,
            "status" => 200
        ];
        return response()->json($data, 200);
    }


}
