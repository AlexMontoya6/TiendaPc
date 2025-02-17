<?php

use App\Http\Controllers\{
    Pages\Panel\MiPerfilController,
    Cart\CheckoutController,
    Cart\CartController
};
use App\Http\Controllers\Admin\UserController;
use App\Livewire\Pages\Cart;
use App\Livewire\Pages\Home;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', Home::class)->name('home');


Route::get('/cart', Cart::class)->name('cart.index');

Route::middleware(['auth'])->group(function () {});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/cart/checkout/envio', [CheckoutController::class, 'shipping'])->name('cart.checkout.envio');
    Route::get('/cart/checkout/entrega', [CheckoutController::class, 'delivery'])->name('cart.checkout.entrega');
    Route::post('/cart/checkout/entrega', [CheckoutController::class, 'storeDelivery'])->name('cart.checkout.delivery.store');
    Route::get('/cart/checkout/resumen-pago', [CheckoutController::class, 'resumenPago'])->name('cart.checkout.resumen_pago');
    Route::post('/cart/checkout/pago', [CheckoutController::class, 'storePayment'])->name('cart.checkout.payment.store');
    Route::post('/cart/checkout/procesar', [CheckoutController::class, 'process'])->name('cart.checkout.procesar');

    Route::get('/panel/mi-perfil', [MiPerfilController::class, 'show'])->name('pages.panel.mi-perfil');

    Route::redirect('/user/profile', '/panel/mi-perfil');

    Route::get('/panel/mis-compras', function () {
        return view('pages.panel.mis-compras');
    })->name('pages.panel.mis-compras');

    /**
     * Rutas para Administración (No Customers)
     */
    Route::middleware(['admin'])->group(function () {
        Route::get('/panel/admin', function () {
            return view('pages.panel.admin');
        })->name('pages.panel.admin');

        // ✅ CRUD de Usuarios dentro del panel de administración
        Route::prefix('/panel/admin')->name('admin.')->group(function () {
            Route::resource('users', UserController::class)->names('users');

            Route::put('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.update-role');
        });
    });
});
