<?php

namespace App\Providers;

use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Observers\PaymentObserver;
use App\Policies\ProductPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\ServiceProvider;

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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Payment::observe(PaymentObserver::class);
    }
}
