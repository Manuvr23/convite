<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // En produccion la app corre detras del proxy HTTPS de Render, pero
        // internamente recibe http; forzamos https para que los assets (CSS/JS
        // compilados) y los links no queden como http y el navegador no los bloquee.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
