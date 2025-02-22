<?php

use Tests\Traits\CreatesUsers;

uses(CreatesUsers::class);

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
