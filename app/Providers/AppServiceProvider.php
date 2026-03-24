<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        Paginator::defaultView('vendor.pagination.bulma');
        Paginator::defaultSimpleView('vendor.pagination.simple-bulma');

        View::composer('*', function ($view) {
            $cart = session('cart', []);
            $cartCount = array_sum(array_map(fn ($item) => $item['quantity'] ?? 0, $cart));
            $view->with('cartCount', $cartCount);
        });
    }
}
