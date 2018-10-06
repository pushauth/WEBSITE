<?php

namespace PushAuth\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \PushAuth\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
       // \PushAuth\Http\Middleware\VerifyCsrfToken::class,
        \PushAuth\Http\Middleware\EmptyField::class,
        \PragmaRX\Tracker\Vendor\Laravel\Middlewares\Tracker::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \PushAuth\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \PushAuth\Http\Middleware\RedirectIfAuthenticated::class,
        'ActiveAPI' => \PushAuth\Http\Middleware\ActiveAPI::class,
        'csrf' => \PushAuth\Http\Middleware\VerifyCsrfToken::class,
        'authentication' => \PushAuth\Http\Middleware\Authentication::class,
    ];
}
