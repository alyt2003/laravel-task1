<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Gates the Blade admin dashboard to users with role = admin. Pair
        // with the built-in "auth" middleware on the same route/group; this
        // one only checks role, it doesn't authenticate.
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
        ]);

        // Where the web "auth" middleware sends guests, and where "guest"
        // sends already-logged-in visitors. Scoped to the web session guard
        // only — routes/api.php uses auth:sanctum and always gets a JSON
        // 401 instead (see shouldRenderJsonWhen below), never a redirect.
        $middleware->redirectGuestsTo('/admin/login');
        $middleware->redirectUsersTo('/dashboard');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
