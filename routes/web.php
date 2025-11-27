<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Wszystko w grupie "web" (sesje, cookies, CSRF)
Route::middleware('web')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | AUTH ROUTES
    |--------------------------------------------------------------------------
    */

    // Logowanie
    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login')
        ->middleware('guest');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.post')
        ->middleware('guest');

    // Wylogowanie
    // (osobiście dałbym POST, ale jak chcesz można też GET)
    Route::get('/logout', [AuthController::class, 'logout'])
        ->name('logout')
        ->middleware('auth');

    // Rejestracja
    Route::get('/register', [AuthController::class, 'showRegisterForm'])
        ->name('register')
        ->middleware('guest');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.post')
        ->middleware('guest');

    // Reset hasła – na razie dalej prosty view (nie masz do tego kontrolera)
    Route::get('/resetpassword/{uuid?}/{token?}', function ($uuid = null, $token = null) {
        return view('auth.resetpassword', ['uuid' => $uuid, 'token' => $token]);
    })->name('resetpassword');

    // Weryfikacja maila
    Route::get('/verifyemail/{uuid}/{token}', function ($uuid, $token) {
        return view('auth.verifyemail', ['uuid' => $uuid, 'token' => $token]);
    })->name('verifyemail');

    // Weryfikacja telefonu
    Route::get('verifyphone', function () {
        return view('auth.verifyphone');
    })->name('verifyphone');


    /*
    |--------------------------------------------------------------------------
    | PUBLIC ROUTES
    |--------------------------------------------------------------------------
    */

    Route::get('/', function () {
        return view('guest.welcome');
    });


    /*
    |--------------------------------------------------------------------------
    | PROTECTED (ZALOGOWANY USER)
    |--------------------------------------------------------------------------
    */

    Route::middleware(['auth'])->group(function () {

        // User home / dashboard
        // Możesz używać i /home i /dashboard – obie trasy prowadzą do tego samego widoku
        Route::get('/home', function () {
            return view('users.home');
        })->name('home');

        Route::get('/dashboard', function () {
            return view('users.home');
        })->name('dashboard');

        Route::get('/profile', function () {
            return view('users.profile');
        })->name('profile');

        Route::get('/matches', function () {
            return view('users.matches');
        })->name('matches');
    });


    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */

    Route::middleware(['web', 'auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard tylko dla ADMIN
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard')
          ->middleware('role:ADMIN');

        // Moderacja – ADMIN + MOD
        Route::get('/moderation', function () {
            return view('admin.moderation');
        })->name('moderation')
          ->middleware('role:ADMIN|MOD');

        // Zarządzanie użytkownikami – ADMIN
        Route::get('/users', function () {
            return view('admin.users');
        })->name('users')
          ->middleware('role:ADMIN');

        // cokolwiek dalej...
    });

});
