<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\GameController;

Route::get('/', function () {
    return view('homepage');
});

// Authentication Routes
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [\App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $games = \App\Models\Game::where('status', 'active')->get();
        return view('dashboard', compact('games'));
    })->name('dashboard');

    // Game routes
    Route::get('/computer-parts', [GameController::class, 'showComputerParts'])->name('computer.parts');

    Route::get('/qa-game', function () {
        $game = \App\Models\Game::where('type', 'qa')->first();
        return view('qa_game', compact('game'));
    })->name('qa.game');
    Route::post('/save-score', [GameController::class, 'saveScore'])->name('save.score');
    Route::get('/leaderboard', [GameController::class, 'leaderboard'])->name('leaderboard');
});

// Admin Routes
Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/games', [AdminDashboardController::class, 'storeGame'])->name('admin.games.store');
    Route::put('/games/{game}', [AdminDashboardController::class, 'updateGame'])->name('admin.games.update');
    Route::delete('/games/{game}', [AdminDashboardController::class, 'deleteGame'])->name('admin.games.delete');
});
