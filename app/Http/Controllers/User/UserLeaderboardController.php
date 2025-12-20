<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Score;
use Illuminate\Support\Facades\DB;

class UserLeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $gameType = $request->query('game_type', 'all');
        $limit = $request->query('limit', 100);

        // Get leaderboard data
        $query = User::where('role', 'user')
            ->where('is_disabled', false)
            ->select('users.*')
            ->selectRaw('COALESCE(SUM(scores.score), 0) as total_score')
            ->selectRaw('COUNT(scores.id) as games_played')
            ->leftJoin('scores', 'users.id', '=', 'scores.user_id');

        if ($gameType !== 'all') {
            $query->where('scores.game_type', $gameType);
        }

        $leaderboard = $query
            ->groupBy('users.id', 'users.name', 'users.fname', 'users.lname', 'users.username', 'users.email', 'users.profile_picture', 'users.role', 'users.is_disabled', 'users.created_at', 'users.updated_at')
            ->orderBy('total_score', 'desc')
            ->orderBy('games_played', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($user, $index) {
                return [
                    'rank' => $index + 1,
                    'id' => $user->id,
                    'name' => $user->name,
                    'fname' => $user->fname,
                    'lname' => $user->lname,
                    'username' => $user->username,
                    'profile_picture' => $user->profile_picture,
                    'total_score' => (int) $user->total_score,
                    'games_played' => (int) $user->games_played,
                ];
            });

        // Get current user's rank
        $currentUser = $request->user();
        $currentUserRank = null;
        
        if ($currentUser && $currentUser->role === 'user') {
            $allUsers = User::where('role', 'user')
                ->where('is_disabled', false)
                ->select('users.*')
                ->selectRaw('COALESCE(SUM(scores.score), 0) as total_score')
                ->selectRaw('COUNT(scores.id) as games_played')
                ->leftJoin('scores', 'users.id', '=', 'scores.user_id');

            if ($gameType !== 'all') {
                $allUsers->where('scores.game_type', $gameType);
            }

            $allUsers = $allUsers
                ->groupBy('users.id', 'users.name', 'users.fname', 'users.lname', 'users.username', 'users.email', 'users.profile_picture', 'users.role', 'users.is_disabled', 'users.created_at', 'users.updated_at')
                ->orderBy('total_score', 'desc')
                ->orderBy('games_played', 'desc')
                ->get();

            $rank = 1;
            foreach ($allUsers as $user) {
                if ($user->id === $currentUser->id) {
                    $currentUserRank = [
                        'rank' => $rank,
                        'id' => $user->id,
                        'name' => $user->name,
                        'fname' => $user->fname,
                        'lname' => $user->lname,
                        'username' => $user->username,
                        'profile_picture' => $user->profile_picture,
                        'total_score' => (int) $user->total_score,
                        'games_played' => (int) $user->games_played,
                    ];
                    break;
                }
                $rank++;
            }
        }

        // Get game type statistics
        $gameTypeStats = Score::select('game_type', DB::raw('COUNT(*) as total_games'), DB::raw('SUM(score) as total_score'))
            ->groupBy('game_type')
            ->get()
            ->mapWithKeys(function ($stat) {
                return [$stat->game_type => [
                    'total_games' => (int) $stat->total_games,
                    'total_score' => (int) $stat->total_score,
                ]];
            });

        return response()->json([
            'status' => 'success',
            'leaderboard' => $leaderboard,
            'current_user_rank' => $currentUserRank,
            'game_type_stats' => $gameTypeStats,
            'filter' => [
                'game_type' => $gameType,
                'limit' => $limit,
            ],
        ]);
    }
}
