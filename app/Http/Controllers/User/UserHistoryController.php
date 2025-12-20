<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Score;
use Illuminate\Support\Facades\DB;

class UserHistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $history = Score::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get()
            ->map(function (Score $score) {
                $labelMap = [
                    'qa_fps' => 'Q&A FPS',
                    'typergel1' => 'TyperGel1',
                    'assessment' => 'Assessment',
                    'guess_part' => 'Guess Part',
                    'lesson' => 'Lesson',
                ];

                $gameType = $score->game_type;
                $label = $labelMap[$gameType] ?? ucfirst(str_replace('_', ' ', $gameType));

                return [
                    'id' => $score->id,
                    'game_type' => $gameType,
                    'game_label' => $label,
                    'score' => (int) $score->score,
                    'played_at' => $score->created_at->toDateTimeString(),
                ];
            });

        $perGameStats = Score::where('user_id', $user->id)
            ->select('game_type', DB::raw('COUNT(*) as sessions'), DB::raw('SUM(score) as total_score'))
            ->groupBy('game_type')
            ->get()
            ->mapWithKeys(function ($row) {
                return [
                    $row->game_type => [
                        'sessions' => (int) $row->sessions,
                        'total_score' => (int) $row->total_score,
                    ],
                ];
            });

        $totalScore = $history->sum('score');
        $totalSessions = $history->count();

        return response()->json([
            'status' => 'success',
            'history' => $history,
            'stats' => [
                'total_score' => $totalScore,
                'total_sessions' => $totalSessions,
                'per_game' => $perGameStats,
            ],
        ]);
    }
}

