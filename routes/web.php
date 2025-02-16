<?php

use App\Http\Controllers\{
    Pages\HomeController,
    Pages\Panel\MiPerfilController
};
use App\Livewire\Home;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', Home::class)->name('home');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    /**
     * Rutas para Clientes (Customer)
     */
    Route::get('/panel/mi-perfil', [MiPerfilController::class, 'show'])
        ->name('pages.panel.mi-perfil');

    // Redirigir cualquier acceso a /user/profile hacia /panel/mi-perfil
    Route::redirect('/user/profile', '/panel/mi-perfil');

    Route::get('/panel/mis-compras', function () {
        return view('pages.panel.mis-compras');
    })->name('pages.panel.mis-compras');

    /**
     * Rutas para Administración (No Customers)
     */
    Route::get('/panel/admin', function () {
        abort_unless(auth()->user()->hasRole(['Admin', 'SuperAdmin']), 403);
        return view('pages.panel.admin');
    })->name('pages.panel.admin');

});
