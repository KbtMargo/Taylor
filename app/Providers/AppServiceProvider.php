<?php

namespace App\Providers;

use App\View\Components\ChatComposer; 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View; 
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ...
    }

    public function boot(): void
    {
        Route::aliasMiddleware('query.mode', QueryModeMiddleware::class);
        View::composer('layouts.app', ChatComposer::class);

    }
}
