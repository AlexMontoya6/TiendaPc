<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        $roles = Role::all(); // Obtener todos los roles desde la base de datos

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        // Remover todos los roles actuales y asignar el nuevo
        $user->syncRoles([$request->role]);

        return back()->with('success', 'Rol actualizado correctamente.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $this->authorize('create', User::class);
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.users.index')->with('error', 'No tienes permisos para crear usuarios.');
        }

        $roles = Role::all(); // Obtener todos los roles desde la base de datos

        return view('pages.panel.users.create', compact('roles'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        try {
            $this->authorize('create', User::class);
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.users.index')->with('error', 'No tienes permisos para crear usuarios.');
        }

        // Verificar que el rol realmente existe en la base de datos antes de asignarlo
        if (!Role::where('name', $request->role)->exists()) {
            return redirect()->route('admin.users.index')->with('error', 'El rol seleccionado no es válido.');
        }

        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Asignar el rol
        try {
            $user->assignRole($request->role);
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')->with('error', 'No se pudo asignar el rol al usuario.');
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado correctamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {

        try {
            $this->authorize('update', $user); // 🔹 Pasar el usuario real
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.users.index')->with('error', 'No tienes permisos para editar usuarios.');
        }

        $roles = Role::all(); // Obtener todos los roles disponibles

        return view('pages.panel.users.edit', compact('user', 'roles'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->authorize('update', $user); // ✅ Pasamos el usuario real para la autorización

        try {
            // Obtener los datos validados del request
            $data = $request->validated();

            // Si el usuario ingresó una nueva contraseña, encriptarla, si no, eliminarla del array
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            } else {
                unset($data['password']); // No actualizar la contraseña si está vacía
            }

            $user->update($data); // ✅ Actualiza solo los datos validados

            // Sincronizar roles
            $user->syncRoles([$request->role]);

            return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')->with('error', 'Hubo un error al actualizar el usuario.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $this->authorize('delete', $user);
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.users.index')->with('error', 'No tienes permisos para eliminar usuarios.');
        }

        // Prevenir que un usuario se elimine a sí mismo
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        // Eliminar el usuario
        $user->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
