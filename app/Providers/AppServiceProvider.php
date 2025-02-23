<?php

namespace App\Providers;

use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Observers\PaymentObserver;
use App\Policies\ProductPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\ServiceProvider;
use L5Swagger\L5SwaggerServiceProvider;

/**
 * @OA\Info(
 *   title="TiendaPc API",
 *   version="1.0.0",
 *   description="Documentación de la API"
 * )
 *
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT"
 * )
 */
class AppServiceProvider extends ServiceProvider
{

    protected $policies = [
        User::class => UserPolicy::class,
        Product::class => ProductPolicy::class,
    ];


    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(L5SwaggerServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Payment::observe(PaymentObserver::class);
    }
}
