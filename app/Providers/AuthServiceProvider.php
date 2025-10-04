<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\AtelierPhoto; // Імпортуємо модель
use App\Policies\AtelierPhotoPolicy; // Імпортуємо політику

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // ... інші політики ...
        AtelierPhoto::class => AtelierPhotoPolicy::class, // <-- Додаємо цю лінію
    ];

    public function boot(): void
    {
        //
    }
}