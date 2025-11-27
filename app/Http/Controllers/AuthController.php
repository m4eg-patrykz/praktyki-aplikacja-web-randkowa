<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
<<<<<<< HEAD
use App\Models\Role;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // zrobisz prosty widok
=======

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
>>>>>>> main
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
<<<<<<< HEAD

            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'email' => 'Nieprawidłowy login lub hasło.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'max:32', 'confirmed'],
        ]);

        // domyślna rola: USER (id=1 lub code=USER)
        $role = Role::where('code', 'USER')->first(); // z Twojego seeda

        $user = User::create([
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id'  => $role?->id ?? 1,
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }
}
=======
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
>>>>>>> main
