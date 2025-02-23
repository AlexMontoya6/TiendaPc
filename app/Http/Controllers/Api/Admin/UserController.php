<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin/users",
     *     summary="Listar todos los usuarios",
     *     description="Devuelve una lista de usuarios. Solo accesible por SuperAdmin.",
     *     tags={"Usuarios"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Response(response=200, description="Lista de usuarios obtenida correctamente"),
     *     @OA\Response(response=403, description="No autorizado"),
     * )
     */
    public function index()
    {
        Gate::authorize('viewAny', User::class);

        return response()->json([
            'success' => true,
            'data' => User::orderBy('id', 'desc')->get(),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/admin/users/{id}",
     *     summary="Obtener detalles de un usuario",
     *     description="Devuelve los detalles de un usuario. Solo accesible por SuperAdmin.",
     *     tags={"Usuarios"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(name="id", in="path", required=true, description="ID del usuario"),
     *
     *     @OA\Response(response=200, description="Detalles del usuario obtenidos correctamente"),
     *     @OA\Response(response=403, description="No autorizado"),
     *     @OA\Response(response=404, description="Usuario no encontrado"),
     * )
     */
    public function show(User $user)
    {
        Gate::authorize('view', $user);

        return response()->json([
            'success' => true,
            'data' => $user,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/admin/users",
     *     summary="Crear un nuevo usuario",
     *     description="Permite a un SuperAdmin crear un nuevo usuario.",
     *     tags={"Usuarios"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *
     *             @OA\Property(property="name", type="string", example="Nuevo Usuario"),
     *             @OA\Property(property="email", type="string", example="user@mail.com"),
     *             @OA\Property(property="password", type="string", example="password123"),
     *             @OA\Property(property="role", type="string", example="Customer")
     *         )
     *     ),
     *
     *     @OA\Response(response=201, description="Usuario creado correctamente"),
     *     @OA\Response(response=403, description="No autorizado"),
     *     @OA\Response(response=422, description="Datos inválidos"),
     * )
     */
    public function store(Request $request)
    {
        Gate::authorize('create', User::class); // 🔥 Solo SuperAdmin puede crear usuarios

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:SuperAdmin,Admin,Customer',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole($request->role); // 🔥 Asignamos el rol al usuario

        return response()->json(['message' => 'Usuario creado correctamente', 'data' => $user], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/admin/users/{id}",
     *     summary="Actualizar un usuario",
     *     description="Permite a un SuperAdmin actualizar un usuario.",
     *     tags={"Usuarios"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(name="id", in="path", required=true, description="ID del usuario"),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="name", type="string", example="Usuario Modificado"),
     *             @OA\Property(property="email", type="string", example="nuevo@mail.com"),
     *             @OA\Property(property="password", type="string", example="newpassword123"),
     *             @OA\Property(property="role", type="string", example="Admin")
     *         )
     *     ),
     *
     *     @OA\Response(response=200, description="Usuario actualizado correctamente"),
     *     @OA\Response(response=403, description="No autorizado"),
     *     @OA\Response(response=404, description="Usuario no encontrado"),
     * )
     */
    public function update(Request $request, User $user)
    {
        Gate::authorize('update', $user); // 🔥 Solo SuperAdmin puede modificar

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,'.$user->id,
            'password' => 'sometimes|string|min:6',
            'role' => 'sometimes|in:SuperAdmin,Admin,Customer',
        ]);

        $user->update($request->only(['name', 'email', 'password']));

        if ($request->has('role')) {
            $user->syncRoles($request->role);
        }

        return response()->json(['message' => 'Usuario actualizado correctamente', 'data' => $user]);
    }

    /**
     * @OA\Delete(
     *     path="/api/admin/users/{id}",
     *     summary="Eliminar un usuario",
     *     description="Permite a un SuperAdmin eliminar un usuario.",
     *     tags={"Usuarios"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(name="id", in="path", required=true, description="ID del usuario"),
     *
     *     @OA\Response(response=200, description="Usuario eliminado correctamente"),
     *     @OA\Response(response=403, description="No autorizado"),
     *     @OA\Response(response=404, description="Usuario no encontrado"),
     * )
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete', $user); // 🔥 Solo SuperAdmin puede eliminar

        $user->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente.']);
    }
}
