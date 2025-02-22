<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Tests\Traits\CreatesUsers;

uses(CreatesUsers::class);


//PARA EL INDEX
it('permite a un admin ver la lista de usuarios', function () {
    $this->actingAsSuperAdmin();

    $this->get(route('admin.users.index'))
        ->assertOk()
        ->assertSee('Usuarios'); // Ajusta esto al título real de la vista
});

it('impide a un usuario no autorizado ver la lista de usuarios', function () {
    self::loginAsUser();

    $this->get(route('admin.users.index'))
        ->assertForbidden();
});

//PARA EL CREATE
it('permite a un admin acceder al formulario de creación de usuarios', function () {
    $this->actingAsSuperAdmin();

    $this->get(route('admin.users.create'))
        ->assertOk()
        ->assertSee('Crear Usuario'); // Ajusta esto si el formulario tiene otro título
});

it('impide a un usuario sin permisos acceder a la creación de usuarios', function () {
    self::loginAsUser();

    $this->get(route('admin.users.create'))
        ->assertForbidden(); // O `assertRedirect()` si el middleware lo redirige
});

//PARA EL STORE
it('permite a un admin crear un usuario', function () {
    $this->actingAsSuperAdmin();

    $role = Role::firstOrCreate(['name' => 'Customer']);

    $data = [
        'name' => 'Nuevo Usuario',
        'email' => 'nuevo@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => $role->name,
    ];

    $response = $this->post(route('admin.users.store'), $data);

    $this->assertDatabaseHas('users', [
        'name' => 'Nuevo Usuario',
        'email' => 'nuevo@example.com',
    ]);

    $user = User::where('email', 'nuevo@example.com')->first();
    expect($user->hasRole($role->name))->toBeTrue();

    $response->assertRedirect(route('admin.users.index'));
    $response->assertSessionHas('success', 'Usuario creado correctamente.');
});

it('impide a un usuario sin permisos crear un usuario', function () {
    self::loginAsUser();

    $role = Role::firstOrCreate(['name' => 'Customer']);

    $data = [
        'name' => 'Nuevo Usuario',
        'email' => 'nuevo@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => $role->name,
    ];

    $this->post(route('admin.users.store'), $data)
        ->assertForbidden();
});

//PARA EL EDIT
it('permite a un admin acceder a la página de edición de usuarios', function () {
    $admin = $this->actingAsSuperAdmin();
    $user = User::factory()->create();

    $this->get(route('admin.users.edit', $user))
        ->assertOk()
        ->assertSee($user->name)
        ->assertSee('Editar Usuario');
});

it('impide a un usuario sin permisos acceder a la edición de usuarios', function () {
    self::loginAsUser();

    $user = User::factory()->create();

    $this->get(route('admin.users.edit', $user))
        ->assertForbidden();
});

//PARA EL UPDATE
it('permite a un admin actualizar un usuario', function () {
    $this->actingAsSuperAdmin();

    $user = User::factory()->create();

    $data = [
        'name' => 'Usuario Actualizado',
        'email' => 'nuevo-email@example.com',
        'password' => 'nuevaPassword123',
        'password_confirmation' => 'nuevaPassword123',
        'role' => 'SuperAdmin', // Asegurar que el rol existe
    ];

    $this->put(route('admin.users.update', $user), $data)
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success', 'Usuario actualizado correctamente.');

    // Verificar en la BD
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Usuario Actualizado',
        'email' => 'nuevo-email@example.com',
    ]);
});

it('impide a un usuario sin permisos actualizar otro usuario', function () {
    self::loginAsUser(); // Usuario normal sin permisos

    $user = User::factory()->create();

    $data = [
        'name' => 'Intento de Cambio',
        'email' => 'hack@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'SuperAdmin',
    ];

    $this->put(route('admin.users.update', $user), $data)
        ->assertForbidden(); // O `assertRedirect()` si hay middleware

    // Verificar que NO se actualizó
    $this->assertDatabaseMissing('users', [
        'id' => $user->id,
        'name' => 'Intento de Cambio',
    ]);
});

//PARA EL DESTROY
it('permite a un admin eliminar un usuario', function () {
    $this->actingAsSuperAdmin();

    $user = User::factory()->create();

    $this->delete(route('admin.users.destroy', $user))
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success', 'Usuario eliminado correctamente.');

    // Verificar en la BD que el usuario ya no existe
    $this->assertDatabaseMissing('users', [
        'id' => $user->id,
    ]);
});

it('impide a un usuario sin permisos eliminar otro usuario', function () {
    self::loginAsUser(); // Usuario sin permisos

    $user = User::factory()->create();

    $this->delete(route('admin.users.destroy', $user))
        ->assertForbidden(); // O `assertRedirect()` si hay middleware

    // Verificar que el usuario sigue existiendo
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
    ]);
});
