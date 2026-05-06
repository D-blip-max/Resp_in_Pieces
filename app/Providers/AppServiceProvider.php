<?php

namespace App\Providers;

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
        // Registrar eventos para vitácora
        \Illuminate\Support\Facades\Event::listen(\Illuminate\Auth\Events\Login::class, function ($event) {
            \App\Models\Vitacora::create([
                'usuario' => $event->user->name,
                'accion' => 'Log in',
                'hora' => now(),
            ]);
        });

        \Illuminate\Support\Facades\Event::listen(\Illuminate\Auth\Events\Logout::class, function ($event) {
            if ($event->user) {
                \App\Models\Vitacora::create([
                    'usuario' => $event->user->name,
                    'accion' => 'Log out',
                    'hora' => now(),
                ]);
            }
        });
    }
}
