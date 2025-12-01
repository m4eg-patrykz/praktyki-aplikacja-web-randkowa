<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserNotSuspended
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && $user->hasActiveSuspension()) {
            $suspension = $user->getActiveSuspension();
            $expires = $suspension['permanent'] ? 'nigdy' : ($suspension['expires_at']
                ? date('d.m.Y H:i', strtotime($suspension['expires_at'])) : 'nieokreślono');
            $reason = $suspension['reason'] ?? 'nieokreślono powodu';

            Auth::logout();
            abort(403, __('Konto zablokowane: :reason | Blokada wygasa :expires', [
                'reason' => $reason,
                'expires' => $expires,
            ]));
        }

        return $next($request);
    }
}
// ...existing code...