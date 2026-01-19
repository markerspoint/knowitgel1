<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminAssessmentController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\User\UserFPSGameController;
use App\Http\Controllers\User\UserTyperGelController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\UserLeaderboardController;
use App\Http\Controllers\User\UserHistoryController;
use App\Http\Controllers\User\UserSettingsController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/user', function (Request $request) {
        $user = $request->user();
        $user->load(['scores', 'completedLessons', 'assessments']);
        
        return response()->json([
            'status' => 'success',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'fname' => $user->fname,
                'lname' => $user->lname,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role,
                'profile_picture' => $user->profile_picture,
                'is_disabled' => $user->is_disabled,
                'total_score' => $user->scores->sum('score') ?? 0,
                'games_played' => $user->scores->count() ?? 0,
                'lessons_completed' => $user->completedLessons->count() ?? 0,
                'has_completed_assessment' => $user->hasCompletedAssessment(),
            ]
        ]);
    });
    
    Route::get('/user/dashboard-data', function (Request $request) {
        $games = \App\Models\Game::where('status', 'active')->get();
        $user = $request->user();
        $user->load(['scores', 'completedLessons']);
        
        $totalScore = $user->scores->sum('score') ?? 0;
        $gamesPlayed = $user->scores->count() ?? 0;
        $assessmentScore = $user->scores()
            ->where('game_type', 'assessment')
            ->sum('score') ?? 0;
        
        return response()->json([
            'status' => 'success',
            'games' => $games,
            'stats' => [
                'total_score' => $totalScore,
                'games_played' => $gamesPlayed,
                'assessment_score' => $assessmentScore,
            ]
        ]);
    });

    Route::get('/assessment/questions', [AssessmentController::class, 'questions']);
    Route::post('/assessment/submit', [AssessmentController::class, 'submit']);

    Route::get('/user/qa-fps/questions', [UserFPSGameController::class, 'questions']);
    Route::post('/user/qa-fps/result', [UserFPSGameController::class, 'submitResult']);

    Route::get('/user/typergel/config', [UserTyperGelController::class, 'config']);
    Route::post('/user/typergel/result', [UserTyperGelController::class, 'submitResult']);
    
    Route::get('/user/profile', [UserProfileController::class, 'show']);
    Route::post('/user/profile', [UserProfileController::class, 'update']);
    
    Route::get('/user/leaderboard', [UserLeaderboardController::class, 'index']);
    Route::get('/user/history', [UserHistoryController::class, 'index']);
    Route::post('/user/settings/password', [UserSettingsController::class, 'updatePassword']);
    Route::get('/user/game-settings', function (Request $request) {
        return response()->json([
            'status' => 'success',
            'settings' => [
                'qa_fps_enabled' => \App\Models\Setting::isEnabled('qa_fps_enabled'),
                'typergel1_enabled' => \App\Models\Setting::isEnabled('typergel1_enabled'),
            ],
        ]);
    });
    
    Route::get('/user/studies', function (Request $request) {
        $lessons = \App\Models\Lesson::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json([
            'status' => 'success',
            'studies' => $lessons,
        ]);
    });
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/profile', [AdminProfileController::class, 'show']);
    Route::post('/profile', [AdminProfileController::class, 'update']);
    Route::get('/settings/games', [AdminSettingsController::class, 'getGameSettings']);
    Route::post('/settings/games', [AdminSettingsController::class, 'updateGameSettings']);
    Route::post('/settings/password', [AdminSettingsController::class, 'updatePassword']);
    Route::get('/dashboard-data', function (Request $request) {
        $users = \App\Models\User::all();
        $games = \App\Models\Game::all();
        $lessons = \App\Models\Lesson::all();

        $totalUsers = $users->count();
        $newUsersLast30 = \App\Models\User::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $disabledUsers = \App\Models\User::where('is_disabled', true)->count();
        $activeUsers = \App\Models\User::where('is_disabled', false)->count();
        $adminUsers = \App\Models\User::where('role', 'admin')->count();
        $regularUsers = \App\Models\User::where('role', 'user')->count();

        $totalSessions = \App\Models\Score::count();
        $totalScore = \App\Models\Score::sum('score');

        $startDate = Carbon::now()->subDays(29)->startOfDay();
        $dailyScores = \App\Models\Score::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as sessions'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dailySeries = [];
        $cursor = $startDate->copy();
        while ($cursor->lte(Carbon::today())) {
            $dateStr = $cursor->toDateString();
            $match = $dailyScores->firstWhere('date', $dateStr);
            $dailySeries[] = [
                'date' => $dateStr,
                'sessions' => $match ? (int) $match->sessions : 0,
            ];
            $cursor->addDay();
        }

        $startMonth = Carbon::now()->subMonths(11)->startOfMonth();
        $monthlyScores = \App\Models\Score::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as sessions')
            )
            ->where('created_at', '>=', $startMonth)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $monthlySeries = [];
        $cursorMonth = $startMonth->copy();
        while ($cursorMonth->lte(Carbon::now()->startOfMonth())) {
            $year = (int) $cursorMonth->year;
            $month = (int) $cursorMonth->month;
            $label = $cursorMonth->format('M Y');
            $match = $monthlyScores->first(function ($row) use ($year, $month) {
                return (int) $row->year === $year && (int) $row->month === $month;
            });
            $monthlySeries[] = [
                'label' => $label,
                'sessions' => $match ? (int) $match->sessions : 0,
            ];
            $cursorMonth->addMonth();
        }

        return response()->json([
            'status' => 'success',
            'users' => $users,
            'games' => $games,
            'lessons' => $lessons,
            'analytics' => [
                'totals' => [
                    'total_users' => $totalUsers,
                    'new_users_last_30_days' => $newUsersLast30,
                    'total_sessions' => $totalSessions,
                    'total_score' => $totalScore,
                ],
                'user_stats' => [
                    'total_users' => $totalUsers,
                    'active_users' => $activeUsers,
                    'disabled_users' => $disabledUsers,
                    'admin_users' => $adminUsers,
                    'regular_users' => $regularUsers,
                ],
                'daily_sessions_last_30_days' => $dailySeries,
                'monthly_sessions_last_12_months' => $monthlySeries,
            ],
        ]);
    });
    
    Route::patch('/users/{user}/toggle-status', [AdminDashboardController::class, 'toggleStatus']);
    Route::delete('/users/{user}', [AdminDashboardController::class, 'deleteUser']);
    Route::post('/games', [AdminDashboardController::class, 'storeGame']);
    Route::put('/games/{game}', [AdminDashboardController::class, 'updateGame']);
    Route::delete('/games/{game}', [AdminDashboardController::class, 'deleteGame']);
    Route::post('/lessons', [AdminDashboardController::class, 'storeLesson']);
    Route::put('/lessons/{lesson}', [AdminDashboardController::class, 'updateLesson']);
    Route::delete('/lessons/{lesson}', [AdminDashboardController::class, 'deleteLesson']);
    
    Route::get('/assessment/questions', [AdminAssessmentController::class, 'index']);
    Route::post('/assessment/questions', [AdminAssessmentController::class, 'store']);
    Route::post('/assessment/questions/{game}', [AdminAssessmentController::class, 'update']);
    Route::delete('/assessment/questions/{game}', [AdminAssessmentController::class, 'destroy']);
});

