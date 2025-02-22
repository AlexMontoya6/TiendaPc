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


