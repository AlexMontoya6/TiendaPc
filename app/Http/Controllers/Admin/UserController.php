<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
    public function store(Request $request)
    {

        try {
            $this->authorize('create', User::class);
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.users.index')->with('error', 'No tienes permisos para crear usuarios.');
        }

        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => ['required', Rule::exists('roles', 'name')], // Verifica que el rol existe
        ]);

        // Crear el usuario en la base de datos
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Asignar el rol seleccionado al usuario
        $user->assignRole($request->role);

        // Redirigir con un mensaje de éxito
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
    public function update(Request $request, User $user)
    {

        try {
            $this->authorize('update', User::class); // 🔹 Pasar el usuario real
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.users.index')->with('error', 'No tienes permisos para editar usuarios.');
        }

        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6|confirmed',
            'role' => ['required', Rule::exists('roles', 'name')], // Asegura que el rol exista en la base de datos
        ]);

        // Actualizar los datos del usuario
        $user->name = $request->name;
        $user->email = $request->email;

        // Solo actualizar la contraseña si el usuario ingresó una nueva
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Asignar el nuevo rol al usuario
        $user->syncRoles([$request->role]);

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente.');
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
