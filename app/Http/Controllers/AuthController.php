<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function showEmailVerify()
    {
        return view('auth.verifyemail');
    }

    public function showPhoneVerify()
    {
        return view('auth.verifyphone');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            if (!$request->user()->hasVerifiedEmail()) {
                return redirect('/email/verify');
            }

            if (!$request->user()->hasVerifiedPhone()) {
                return redirect('/phone/verify');
            }

            return redirect()->route('home'); // tutaj możesz zmienić na np. /dashboard
        }

        return back()->withErrors([
            'email' => 'Nieprawidłowy e-mail lub hasło.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        event(new Registered($user));

        // Możesz od razu zalogować, ale blokujemy dostęp do części panelu przez middleware 'verified'
        Auth::login($user);

        // Przekierowanie do strony z informacją o weryfikacji emaila   
        return redirect()->route('email.verification.notice');
    }

    public function sendVerifyEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        $request->user()->sendEmailVerificationNotification();

        return redirect()
            ->route('email.verification.notice')
            ->with('status', 'verification-link-sent');
    }

    public function sendVerifyPhone(Request $request)
    {
        // Logika wysyłania kodu weryfikacyjnego na telefon
        return redirect()
            ->route('phone.verification.notice')
            ->with('status', 'verification-code-sent');
    }
}