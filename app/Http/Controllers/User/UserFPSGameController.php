<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Score;
use App\Models\Setting;

class UserFPSGameController extends Controller
{
    public function questions(Request $request)
    {
        if (!Setting::isEnabled('qa_fps_enabled')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Q&A FPS game is currently disabled.',
            ], 403);
        }

        $request->validate([
            'difficulty' => 'nullable|in:easy,medium,hard',
        ]);

        $games = Game::where('type', 'qa')
            ->where('status', 'active')
            ->inRandomOrder()
            ->limit(10)
            ->get();

        $questions = $games->map(function (Game $game) {
            $options = $game->options;

            if (is_string($options)) {
                $decoded = json_decode($options, true);
                $options = is_array($decoded) ? $decoded : [];
            }

            if (!is_array($options)) {
                $options = [];
            }

            if (!in_array($game->answer, $options, true)) {
                $options[] = $game->answer;
            }

            shuffle($options);

            return [
                'id' => $game->id,
                'question' => $game->question,
                'correct_answer' => $game->answer,
                'options' => array_values($options),
                'description' => $game->description,
            ];
        });

        return response()->json([
            'status' => 'success',
            'questions' => $questions,
        ]);
    }

    public function submitResult(Request $request)
    {
        $request->validate([
            'score' => 'required|integer|min:0',
        ]);

        $user = $request->user();

        Score::create([
            'user_id' => $user->id,
            'score' => $request->input('score'),
            'game_type' => 'qa_fps',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Result saved successfully.',
        ]);
    }
}


