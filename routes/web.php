<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Panel\MiPerfilController;
use App\Http\Controllers\Panel\MisComptrasController;
use App\Http\Controllers\PaypalController;
use App\Livewire\Pages\Admin\Dashboard;
use App\Livewire\Pages\Admin\Products;
use App\Livewire\Pages\Cart;
use App\Livewire\Pages\Checkout\Direcciones;
use App\Livewire\Pages\Checkout\Entrega;
use App\Livewire\Pages\Checkout\ResumenPago;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\ProductDetail;
use Illuminate\Support\Facades\Route;

Route::post('paypal', [PaypalController::class, 'paypal'])->name('paypal.payment');
Route::get('/payment/success', [PaypalController::class, 'success'])->name('success');
Route::get('/payment/cancel', [PaypalController::class, 'cancel'])->name('cancel');

Route::get('/', Home::class)->name('home');
Route::get('/cart', Cart::class)->name('cart.index');
Route::get('/{product:slug}', ProductDetail::class)->name('product.detail');

// Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.products');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/cart/checkout/direcciones', Direcciones::class)->name('cart.checkout.direcciones');
    Route::get('/cart/checkout/entrega', Entrega::class)->name('cart.checkout.entrega');
    Route::get('/cart/checkout/resumen-pago', ResumenPago::class)->name('cart.checkout.resumen_pago');

    Route::get('/panel/mi-perfil', [MiPerfilController::class, 'show'])->name('panel.mi-perfil');

    Route::redirect('/user/profile', '/panel/mi-perfil');

    Route::get('/panel/mis-compras', [MisComptrasController::class, 'index'])->name('panel.mis-compras');
    Route::get('/payments/{payment}/ticket', [MisComptrasController::class, 'generatePDF'])->name('payments.ticket');

    /**
     * Rutas para Administración (No Customers)
     */
    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');

        Route::resource('products', ProductController::class)->names('products');

        Route::resource('users', UserController::class)->names('users');
        Route::put('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.update-role');
    });
});
