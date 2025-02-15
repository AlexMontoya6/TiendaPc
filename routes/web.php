<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Panel\MiPerfilController; // Nuestro nuevo controlador para el perfil

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    /**
     * Rutas para Clientes (Customer)
     */
    Route::get('/panel/mi-perfil', [MiPerfilController::class, 'show'])
        ->name('panel.mi-perfil');

    // Redirigir cualquier acceso a /user/profile hacia /panel/mi-perfil
    Route::redirect('/user/profile', '/panel/mi-perfil');

    Route::get('/panel/mis-compras', function () {
        return view('panel.mis-compras');
    })->name('panel.mis-compras');

    /**
     * Rutas para Administración (No Customers)
     */
    Route::middleware(['role:Admin|SuperAdmin'])->group(function () {
        Route::get('/panel/admin', function () {
            return view('panel.admin');
        })->name('panel.admin');
    });

});
