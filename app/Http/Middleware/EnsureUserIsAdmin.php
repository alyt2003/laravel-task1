<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Gate the Blade admin dashboard to users with role = admin.
 *
 * This middleware only checks the role of the already-authenticated user —
 * it does not perform authentication itself. Pair it with the built-in
 * "auth" middleware, which handles the "are you logged in at all" check and
 * redirects guests to /admin/login (configured in bootstrap/app.php):
 *
 *     Route::middleware(['auth', 'admin'])->group(...);
 */
class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            abort(403, 'You do not have permission to access the admin dashboard.');
        }

        return $next($request);
    }
}
