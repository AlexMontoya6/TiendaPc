<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Iniciar sesión y obtener un token de acceso",
     *     tags={"Autenticación"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Credenciales de inicio de sesión",
     *
     *         @OA\JsonContent(
     *             required={"email","password"},
     *
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="secret")
     *         )
     *     ),
     *
     *     @OA\Response(response=200, description="Inicio de sesión exitoso"),
     *     @OA\Response(response=401, description="Credenciales inválidas")
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        $user = Auth::user();

        // Crear el token con Sanctum
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Registrar un nuevo usuario",
     *     tags={"Autenticación"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos para registrar un usuario",
     *
     *         @OA\JsonContent(
     *             required={"name","email","password","password_confirmation"},
     *
     *             @OA\Property(property="name", type="string", example="Juan"),
     *             @OA\Property(property="email", type="string", format="email", example="juan@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="secret")
     *         )
     *     ),
     *
     *     @OA\Response(response=201, description="Usuario registrado correctamente"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        // Generamos token
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'user' => $user,
            'token' => $token,
        ], 201);
    }
}
