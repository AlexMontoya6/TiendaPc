<?php

use App\Http\Controllers\{
    Pages\Panel\MiPerfilController,
    Cart\CheckoutController,
    Cart\CartController
};
use App\Livewire\Home;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', Home::class)->name('home');


Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/cart/checkout/envio', [CheckoutController::class, 'shipping'])->name('cart.checkout.envio');
    Route::get('/cart/checkout/entrega', [CheckoutController::class, 'delivery'])->name('cart.checkout.entrega');
    Route::post('/cart/checkout/entrega', [CheckoutController::class, 'storeDelivery'])->name('cart.checkout.delivery.store');
    Route::get('/cart/checkout/resumen-pago', [CheckoutController::class, 'resumenPago'])->name('cart.checkout.resumen_pago');
    Route::post('/cart/checkout/pago', [CheckoutController::class, 'storePayment'])->name('cart.checkout.payment.store');
    Route::post('/cart/checkout/procesar', [CheckoutController::class, 'process'])->name('cart.checkout.procesar');
});

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
