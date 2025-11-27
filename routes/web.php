<?php

use Illuminate\Support\Facades\Route;

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
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('users.home');
    })->name('home');

    Route::get('/profile', function () {
        return view('users.profile');
    })->name('profile');

    Route::get('/matches', function () {
        return view('users.matches');
    })->name('matches');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});