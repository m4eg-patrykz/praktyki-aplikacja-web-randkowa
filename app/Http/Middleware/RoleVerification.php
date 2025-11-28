<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleVerification
{
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = $request->user();

        if (!$user || !$user->hasAnyRole($roles)) {
            abort(403, 'Brak uprawnień (rola).');
        }

        return $next($request);
    }
}
