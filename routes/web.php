<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;


// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::middleware('auth')->group(function () {
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

    Route::group(
        ['prefix' => ''],
        function () {

        }
    )->prefix('email');
    // Strona informująca o konieczności weryfikacji emaila
    Route::get('/email/verify', [AuthController::class, 'showEmailVerify'])
        ->middleware('auth')
        ->name('email.verification.notice');

    // Ponowne wysłanie maila weryfikacyjnego
    Route::post('/email/verify', [AuthController::class, 'sendVerifyEmail'])
        ->middleware('auth')->name('email.verification.send');

    Route::get('/phone/verify', function () {
        return view('auth.verifyphone');
    })->name('phone.verification.notice');

    Route::post('/phone/verify', function (Request $request) {
        // Logika wysyłania kodu weryfikacyjnego na telefon
        return redirect()
            ->route('phone.verification.notice')
            ->with('status', 'verification-code-sent')
            ->with('message', 'Kod weryfikacyjny został wysłany na Twój telefon.');
    })->name('phone.verification.send');
});

// Obsługa kliknięcia w link z maila
Route::get('/email/verify/{uuid}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // oznacza email jako zweryfikowany

    return redirect()->route('home'); // gdzie chcesz po weryfikacji
})->middleware(['signed'])->name('email.verification.verify');

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('guest.landing');
})->middleware('guest')->name('landing');

/*
|--------------------------------------------------------------------------
| PROTECTED (ZALOGOWANY USER)
|--------------------------------------------------------------------------
*/

// Protected Routes
Route::middleware(['auth'/*, 'emailverified', 'phoneverified'*/])->group(function () {
    Route::get('/home', function () {
        return view('user.dashboard');
    })->name('home');

    Route::get('/profile', function () {
        return view('users.profile');
    })->name('profile');

    Route::get('/matches', function () {
        return view('users.matches');
    })->name('matches');

});

// Admin Routes
Route::middleware(['auth', 'role:admin|mod'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});