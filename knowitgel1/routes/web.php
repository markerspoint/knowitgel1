<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('homepage');
});

// User registration
Route::controller(AuthController::class)->group(function () {
    Route::get('/register', 'showRegisterForm')->name('register'); // FIXED method name
    Route::post('/register', 'register')->name('register.submit');
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.submit');
    Route::post('/logout', 'logout')->name('logout');
});

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// games
Route::get('/computer-parts', function () {
    return view('computer_parts');
})->name('computer.parts');

Route::get('/qa-game', function () {
    return view('qa_game');
})->name('qa.game');

