<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use Tests\Traits\CreatesUsers;

uses(CreatesUsers::class);

// Definimos una ruta de prueba protegida por el middleware
beforeEach(function () {
    Route::middleware(['web', AdminMiddleware::class])->get('/admin/test-route', function () {
        return 'Acceso permitido';
    });
});

it('permite el acceso a usuarios con rol de Admin o SuperAdmin', function () {
    $this->actingAsSuperAdmin(); // Se autentica como SuperAdmin

    $this->get('/admin/test-route')
        ->assertOk()
        ->assertSee('Acceso permitido'); // Verifica que la ruta carga correctamente
});

it('impide el acceso a usuarios sin el rol adecuado', function () {
    self::loginAsUser(); // Usuario normal

    $this->get('/admin/test-route')
        ->assertForbidden(); // Debe devolver 403
});
