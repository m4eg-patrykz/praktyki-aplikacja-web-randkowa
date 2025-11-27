<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, string $permissionCode): Response
    {
        $user = $request->user();

        if (! $user || ! $user->hasPermission($permissionCode)) {
            abort(403, 'Brak uprawnień (permisja).');
        }

        return $next($request);
    }
}
