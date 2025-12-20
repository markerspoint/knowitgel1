<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LessonController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $games = \App\Models\Game::where('status', 'active')->get();
        return view('dashboard', compact('games'));
    })->name('dashboard');

    Route::get('/computer-parts', [GameController::class, 'showComputerParts'])->name('computer.parts');
    Route::get('/qa-game', [GameController::class, 'showQAGame'])->name('qa.game');
    Route::post('/save-score', [GameController::class, 'saveScore'])->name('save.score');
    Route::get('/leaderboard', [GameController::class, 'leaderboard'])->name('leaderboard');
    Route::get('/lessons', [LessonController::class, 'game'])->name('lesson.game');
    Route::get('/lessons/{lesson}', [LessonController::class, 'show'])->name('lesson.show');
    Route::post('/lessons/{lesson}/complete', [LessonController::class, 'markAsComplete'])->name('lesson.complete'); 
    Route::get('/user/history', [UserController::class, 'history'])->name('user.history');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::post('/games', [AdminDashboardController::class, 'storeGame'])->name('admin.games.store');
    Route::put('/users/{user}', [AdminDashboardController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminDashboardController::class, 'deleteUser'])->name('admin.users.delete');
    Route::put('/games/{game}', [AdminDashboardController::class, 'updateGame'])->name('admin.games.update');
    Route::delete('/games/{game}', [AdminDashboardController::class, 'deleteGame'])->name('admin.games.delete');
    Route::post('/admin/lessons', [AdminDashboardController::class, 'storeLesson'])->name('admin.lessons.store');
    Route::get('/lessons/{lesson}/edit', [AdminDashboardController::class, 'editLesson'])->name('admin.lessons.edit');
    Route::put('/lessons/{lesson}', [AdminDashboardController::class, 'updateLesson'])->name('admin.lessons.update');
    Route::delete('/lessons/{lesson}', [AdminDashboardController::class, 'deleteLesson'])->name('admin.lessons.delete'); 
    Route::patch('/admin/users/{user}/toggle-status', [AdminDashboardController::class, 'toggleStatus'])->name('admin.users.toggleStatus');
});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
