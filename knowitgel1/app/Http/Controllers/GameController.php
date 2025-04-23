<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Score;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function showComputerParts()
    {
        $games = Game::where('type', 'guess_part')->where('status', 'active')->get();
        return view('computer_parts', compact('games'));
    }

    public function showQAGame()
    {
        $games = \App\Models\Game::where('type', 'qa')->where('status', 'active')->get();
        $games->transform(function ($game) {
            $game->options_array = json_decode($game->options, true) ?? [];
            return $game;
        });
        return view('qa_game', compact('games'));
    }

    public function saveScore(Request $request)
    {
        $request->validate([
            'score' => 'required|integer',
            'game_type' => 'required|string'
        ]);
    
        Score::create([
            'user_id' => auth()->id(),
            'score' => $request->score,
            'game_type' => $request->game_type
        ]);
    
        return response()->json(['success' => true]);
    }

    public function leaderboard()
    {
        $scores = Score::with('user')
            ->orderBy('score', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('leaderboard', compact('scores'));
    }
}
