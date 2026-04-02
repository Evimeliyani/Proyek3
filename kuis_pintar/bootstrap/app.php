<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // ✅ INI YANG BENAR: exclude CSRF untuk endpoint login (biar Postman/Flutter tidak 419)
        $middleware->validateCsrfTokens(except: [
            'login',
            'login/*',
        ]);

        // (opsional) kalau kamu memang butuh alias middleware lain, taruh di sini
        // $middleware->alias([
        //     'something' => \App\Http\Middleware\Something::class,
        // ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
