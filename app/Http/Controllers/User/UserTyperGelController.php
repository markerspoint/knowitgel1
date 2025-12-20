<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Score;
use App\Models\Setting;

class UserTyperGelController extends Controller
{
    public function config(Request $request)
    {
        if (!Setting::isEnabled('typergel1_enabled')) {
            return response()->json([
                'status' => 'error',
                'message' => 'TyperGel1 game is currently disabled.',
            ], 403);
        }

        $request->validate([
            'difficulty' => 'nullable|in:easy,medium,hard',
        ]);

        $games = Game::where('type', 'typergel')
            ->where('status', 'active')
            ->inRandomOrder()
            ->limit(50)
            ->get();

        $words = $games->map(function (Game $game) {
            return [
                'id' => $game->id,
                'word' => $game->question,
            ];
        });

        return response()->json([
            'status' => 'success',
            'words' => $words,
        ]);
    }

    public function submitResult(Request $request)
    {
        $request->validate([
            'score' => 'required|integer|min:0',
            'total_chars' => 'required|integer|min:0',
            'correct_chars' => 'required|integer|min:0',
            'incorrect_chars' => 'required|integer|min:0',
            'accuracy' => 'required|numeric|min:0|max:1',
            'wpm' => 'required|numeric|min:0',
            'difficulty' => 'required|string',
            'duration_seconds' => 'required|numeric|min:0',
        ]);

        $user = $request->user();

        Score::create([
            'user_id' => $user->id,
            'score' => $request->input('score'),
            'game_type' => 'typergel1',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Result saved successfully.',
        ]);
    }
}


