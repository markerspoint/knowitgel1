<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\UserAssessment;
use App\Models\Score;

class AssessmentController extends Controller
{
    public function questions(Request $request)
    {
        $questions = Game::where('type', 'guess_part')
            ->where('status', 'active')
            ->inRandomOrder()
            ->limit(5)
            ->get();

        return response()->json([
            'status' => 'success',
            'questions' => $questions->map(function ($game) {
                return [
                    'id' => $game->id,
                    'title' => $game->title,
                    'description' => $game->description,
                    'question' => $game->question,
                    'answer' => $game->answer,
                    'options' => $game->options,
                    'game_file' => $game->game_file,
                    'thumbnail' => $game->thumbnail,
                    'type' => $game->type,
                    'status' => $game->status
                ];
            })
        ]);
    }

    public function submit(Request $request)
    {
        $user = $request->user();
        $assessments = $request->input('assessments', []);

        $correctCount = 0;

        foreach ($assessments as $assessment) {
            $game = Game::find($assessment['game_id'] ?? null);
            if ($game) {
                UserAssessment::create([
                    'user_id' => $user->id,
                    'game_id' => $assessment['game_id'],
                    'user_answer' => $assessment['user_answer'],
                    'is_correct' => $assessment['is_correct']
                ]);

                if ($assessment['is_correct']) {
                    $correctCount++;
                }
            }
        }

        Score::create([
            'user_id' => $user->id,
            'score' => $correctCount,
            'game_type' => 'assessment',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Assessment submitted successfully',
            'correct_count' => $correctCount,
            'total_questions' => count($assessments)
        ]);
    }
}
