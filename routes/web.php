<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


// Authentication Routes

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    // Handle login logic
})->name('login.post');

Route::get('/logout', function () {
    return redirect('/');
})->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function () {
    // Handle registration logic
})->name('register.post');

Route::get('/resetpassword/{uuid?}/{token?}', function ($uuid = null, $token = null) {
    return view('auth.resetpassword', ['uuid' => $uuid, 'token' => $token]);
})->name('resetpassword');

Route::get('/verifyemail/{uuid}/{token}', function ($uuid, $token) {
    return view('auth.verifyemail', ['uuid' => $uuid, 'token' => $token]);
})->name('verifyemail');

Route::get('verifyphone', function () {
    return view('auth.verifyphone');
})->name('verifyphone');


// Public Routes
Route::get('/', function () {
    return view('guest.welcome');
});

Route::get('/furrycwel', function() {
    return "Jebać cwela Kacpra Ficonia z ulicy Parkowej 26 w Kobiernicach";
});


// Protected Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // wszystkie trasy, które mają być dostępne dopiero po kliknięciu w link z maila
});

    Route::get('/profile', function () {
        return view('users.profile');
    })->name('profile');

    Route::get('/matches', function () {
        return view('users.matches');
    })->name('matches');

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);



// Ekrany logowania/rejestracji (tylko dla gości – patrz punkt 2)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Strony tylko dla zalogowanych
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard'); // np. główny panel
    })->name('dashboard');

    // tutaj wszystkie inne trasy, które mają być tylko po zalogowaniu
    // Route::get('/profile', ...);
    // Route::get('/zamowienia', ...);
});

// Wylogowanie (też wymaga być zalogowanym)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// Ekran "sprawdź maila"
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Obsługa kliknięcia w link z maila
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // oznacza email jako zweryfikowany

    return redirect()->route('dashboard'); // gdzie chcesz po weryfikacji
})->middleware(['auth', 'signed'])->name('verification.verify');

// Ponowne wysłanie maila weryfikacyjnego
Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect()->route('dashboard');
    }

    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'Link weryfikacyjny został wysłany na Twój adres e-mail.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
