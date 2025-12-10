<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerifyController;
use App\Http\Controllers\PhoneVerifyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SwipeController;
use App\Http\Controllers\LangController;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {

    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // Strona informująca o konieczności weryfikacji emaila
    Route::get('/email/verify', [EmailVerifyController::class, 'notice'])
        ->name('email.verification.notice');

    // Ponowne wysłanie maila weryfikacyjnego
    Route::post('/email/send-link', [EmailVerifyController::class, 'send'])

        ->name('email.verification.send');

    // PHONE VERIFY
    Route::get('/phone/verify', [PhoneVerifyController::class, 'show'])
        ->name('phone.verification.notice');

    Route::post('/phone/send-code', [PhoneVerifyController::class, 'sendCode'])

        ->name('phone.verification.send');

    Route::post('/phone/check-code', [PhoneVerifyController::class, 'checkCode'])
        ->name('phone.verification.check');
});


// Obsługa kliknięcia w link z maila
Route::get('/email/verify/{id}/{hash}', [EmailVerifyController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');


/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('guest.landing');
})->middleware('guest')->name('landing');

Route::get('/lang', [LangController::class, 'show'])->name('lang.show');
Route::get('/lang/{locale}', [LangController::class, 'switch'])->name('lang.switch');

/*
|--------------------------------------------------------------------------
| PROTECTED (ZALOGOWANY USER)
|--------------------------------------------------------------------------
*/

// Protected Routes
Route::middleware(['auth', 'notsuspended', 'emailverified', 'phoneverified'])->name('user.')->group(function () {
    Route::get('/home', [UserController::class, 'home'])->name('home');
    Route::get('/matches', [UserController::class, 'matches'])->name('matches');
    Route::post('/swipes', [SwipeController::class, 'store'])->name('swipes.store');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
});

// Admin Routes
Route::middleware(['auth', 'role:admin|mod'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});





