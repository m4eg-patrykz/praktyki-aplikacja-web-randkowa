<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsurePhoneIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->phone_verified_at) {
            return redirect()->route('phone.verification.notice');
        }

        return $next($request);
    }
}