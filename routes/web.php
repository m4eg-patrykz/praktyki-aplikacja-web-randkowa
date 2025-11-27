<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/resetpassword', function () {
    return view('resetpassword');
})->name('resetpassword');

Route::get('/verifyemail', function () {
    return view('verifyemail');
})->name('verifyemail');

// Protected Routes

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', function () {
        // Logout logic here
        return redirect('/');
    })->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('/matches', function () {
        return view('matches');
    })->name('matches');
});