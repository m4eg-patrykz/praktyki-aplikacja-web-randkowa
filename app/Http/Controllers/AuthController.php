<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/'); // tutaj możesz zmienić na np. /dashboard
        }

        return back()->withErrors([
            'email' => 'Nieprawidłowy e-mail lub hasło.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'              => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
    'name'     => $data['name'],
    'email'    => $data['email'],
    'password' => Hash::make($data['password']),
]);

// Wyślij mail z linkiem weryfikacyjnym
$user->sendEmailVerificationNotification();

// Możesz od razu zalogować, ale blokujemy dostęp do części panelu przez middleware 'verified'
Auth::login($user);

// Przekierowanie na stronę z info "sprawdź maila"
return redirect()->route('verification.notice');
    }



public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
}
}
