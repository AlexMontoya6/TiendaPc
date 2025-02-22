<?php

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Tests\Traits\CreatesUsers;

uses(CreatesUsers::class);

beforeEach(function () {
    Permission::firstOrCreate(['name' => 'crear usuarios', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'editar usuarios', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'eliminar usuarios', 'guard_name' => 'web']);
});

it('permite a un usuario con permiso crear otro usuario', function () {
    $admin = $this->actingAsSuperAdmin();

    expect($admin->can('create', User::class))->toBeTrue();
});

it('impide a un usuario sin permiso crear otro usuario', function () {
    $user = self::loginAsUser(); // Usuario normal sin permisos

    expect($user->can('create', User::class))->toBeFalse();
});

it('permite a un usuario con permiso editar otro usuario', function () {
    $admin = $this->actingAsSuperAdmin();
    $targetUser = User::factory()->create();

    expect($admin->can('update', $targetUser))->toBeTrue();
});

it('impide a un usuario sin permiso editar otro usuario', function () {
    $user = self::loginAsUser(); // Usuario normal sin permisos
    $targetUser = User::factory()->create();

    expect($user->can('update', $targetUser))->toBeFalse();
});

it('permite a un usuario con permiso eliminar otro usuario', function () {
    $admin = $this->actingAsSuperAdmin();
    $targetUser = User::factory()->create();

    expect($admin->can('delete', $targetUser))->toBeTrue();
});

it('impide a un usuario sin permiso eliminar otro usuario', function () {
    $user = self::loginAsUser(); // Usuario normal sin permisos
    $targetUser = User::factory()->create();

    expect($user->can('delete', $targetUser))->toBeFalse();
});
