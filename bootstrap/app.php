<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');
        
        // Register the alias here
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
        $middleware->redirectTo(
            guests: '/login',
            users: '/'
        );
        // Customize the redirect for guests
        $middleware->redirectGuestsTo(function ($request) {
            // Get the first part of the URL (e.g., 'appointments')
            $section = ucfirst($request->segment(1) ?? 'dashboard');

            session()->flash('success', "Please login to access the {$section} section.");

            return route('login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
