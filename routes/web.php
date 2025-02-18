<?php

use App\Http\Controllers\{
    Pages\Panel\MiPerfilController,
    Admin\UserController,
    PaypalController
};

use App\Livewire\Pages\{
    Cart,
    Home,
    Checkout\Direcciones,
    Checkout\Entrega,
    ProductDetail,
};
use App\Livewire\Pages\Admin\Dashboard;
use App\Livewire\Pages\Checkout\ResumenPago;
use Illuminate\Support\Facades\Route;

Route::post('paypal', [PaypalController::class, 'paypal'])->name('paypal.payment');
Route::get('success', [PaypalController::class, 'success'])->name('success');
Route::get('cancel', [PaypalController::class, 'cancel'])->name('cancel');

Route::get('/', Home::class)->name('home');
Route::get('/cart', Cart::class)->name('cart.index');
Route::get('/{product:slug}', ProductDetail::class)->name('product.detail');




Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/cart/checkout/direcciones', Direcciones::class)->name('cart.checkout.direcciones');
    Route::get('/cart/checkout/entrega', Entrega::class)->name('cart.checkout.entrega');
    Route::get('/cart/checkout/resumen-pago', ResumenPago::class)->name('cart.checkout.resumen_pago');


    Route::get('/panel/mi-perfil', [MiPerfilController::class, 'show'])->name('pages.panel.mi-perfil');

    Route::redirect('/user/profile', '/panel/mi-perfil');

    Route::get('/panel/mis-compras', function () {
        return view('pages.panel.mis-compras');
    })->name('pages.panel.mis-compras');

    /**
     * Rutas para Administración (No Customers)
     */
    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');

        // ✅ CRUD de Usuarios dentro del panel de administración (ruta corregida)
        Route::resource('users', UserController::class)->names('users');
        Route::put('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.update-role');
    });

});
