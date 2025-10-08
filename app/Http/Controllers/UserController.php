<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Exception;

class UserController extends Controller
{
    /**
     * Registrar un nuevo usuario
     */
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:6',
                'role' => 'nullable|string|max:50',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'] ?? 'user',
                'password' => Hash::make($validated['password']),
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'status' => 201,
                'msg' => 'Usuario registrado correctamente',
                'user' => $user,
                'token' => $token
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'msg' => 'Error al registrar usuario',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Iniciar sesión (login) y generar token
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 401,
                    'msg' => 'Correo o contraseña inválidos',
                    'error' => 'Credenciales incorrectas'
                ], 401);
            }

            return response()->json([
                'status' => 200,
                'msg' => 'Inicio de sesión exitoso',
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
                'user' => Auth::user(),
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 500,
                'msg' => 'Error al generar token',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtener información del usuario autenticado
     */
    public function me()
    {
        try {
            return response()->json([
                'status' => 200,
                'msg' => 'Usuario autenticado obtenido correctamente',
                'user' => Auth::guard('api')->user(),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'msg' => 'Error al obtener el usuario autenticado',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Refrescar token JWT
     */
    public function refresh()
    {
        try {
            $newToken = Auth::guard('api')->refresh();

            return response()->json([
                'status' => 200,
                'msg' => 'Token refrescado exitosamente',
                'token' => $newToken,
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 500,
                'msg' => 'No se pudo refrescar el token',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Cerrar sesión e invalidar el token
     */
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'status' => 200,
                'msg' => 'Sesión cerrada correctamente',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'msg' => 'Error al cerrar sesión',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
