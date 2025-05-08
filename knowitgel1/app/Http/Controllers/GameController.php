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
        $games = Game::where('type', 'qa')->where('status', 'active')->get();

        $transformedGames = $games->map(function ($game) {
            $options = json_decode($game->options, true) ?? [];
            $questionText = $game->question;
            $answerText = $game->answer;
            $gameId = $game->id;

            \Log::debug("Processing game question", [
                'game_id' => $gameId,
                'question' => $questionText,
                'options' => $options,
                'answer' => $answerText
            ]);

            return [
                'question' => $questionText,
                'options' => $options,
                'correctAnswerIndex' => array_search(strtolower(trim($answerText)), 
                    array_map(function($opt) { 
                        return is_string($opt) ? strtolower(trim($opt)) : $opt; 
                    }, $options))
            ];
        });

        return view('qa_game', ['games' => $transformedGames]);
    }

    public function saveScore(Request $request)
    {
        $score = Score::create([
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
