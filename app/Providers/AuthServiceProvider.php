<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerLoginEvent();
        $this->registerLogoutEvent();
    }

    protected function registerLoginEvent()
    {
        Event::listen(Login::class, function ($event) {
            // Registro de actividad al iniciar sesión
            activity()->event('Inicio sesion')
                ->log('Autenticacion');
        });
    }

    protected function registerLogoutEvent()
    {
        Event::listen(Logout::class, function ($event) {
            // Registro de actividad al cerrar sesión
            activity()->event('Cerro sesion')
                ->log('Autenticacion');
        });
    }
}
