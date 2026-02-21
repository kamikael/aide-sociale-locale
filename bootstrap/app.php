<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Providers;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withProviders(
        [
            App\Providers\AppServiceProvider::class,
            App\Providers\AuthServiceProvider::class,
            App\Providers\EventServiceProvider::class,
        ])
    

    ->withMiddleware(function (Middleware $middleware): void {
      $middleware->alias([
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class, 
         'role' => \App\Http\Middleware\RoleMiddleware::class,
    'active' => \App\Http\Middleware\EnsureAccountIsActive::class,
    'organisateur.validated' => \App\Http\Middleware\EnsureOrganisateurValidated::class,
    'fedapay.webhook' => \App\Http\Middleware\VerifyFedaPayWebhook::class,
]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
