<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // zrobisz prosty widok
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

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
