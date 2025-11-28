<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class EmailVerifyController extends Controller
{
    /**
     * Wyświetlenie ekranu "Sprawdź mail" (/email/verify)
     */
    public function notice()
    {
        return view('auth.verify-email');
    }

    /**
     * Obsługa kliknięcia w link weryfikacyjny
     */
    public function verify(Request $request)
    {
        $user = $request->user();

        // Jeśli email już jest zweryfikowany
        if ($user->hasVerifiedEmail()) {
            if ($user->hasVerifiedPhone()) {
                return redirect()->route('home');
            }
            return redirect()->route('phone.verification.notice');
        }

        // Potwierdzenie emaila
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // Po weryfikacji emaila przechodzimy do weryfikacji telefonu
        return redirect()->route('email.verification.notice')
            ->with('status', 'email-verification-completed');
    }

    /**
     * Ponowne wysłanie maila weryfikacyjnego
     */
    public function send(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            if ($request->user()->hasVerifiedPhone()) {
                return redirect()->route('home');
            }
            return redirect()->route('phone.verification.notice');
        }

        $key = 'verify-email:' . $request->user()->id;
        if (RateLimiter::tooManyAttempts($key, 1)) { // 1 próba na minutę
            return redirect()
                ->route('email.verification.notice')
                ->with('error', 'wait-before-resend');
        }

        RateLimiter::hit($key, 60);

        $request->user()->sendEmailVerificationNotification();

        return redirect()
            ->route('email.verification.notice')
            ->with('status', 'email-verification-sent');
    }
}
