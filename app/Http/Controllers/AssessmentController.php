<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\UserAssessment;
use App\Models\Score;

class AssessmentController extends Controller
{
    private function parseOptions($options): array
    {
        if (is_array($options)) {
            return array_values(array_filter(array_map('trim', $options), fn ($value) => $value !== ''));
        }

        if (is_string($options)) {
            $decoded = json_decode($options, true);
            if (is_array($decoded)) {
                return array_values(array_filter(array_map('trim', $decoded), fn ($value) => $value !== ''));
            }

            return array_values(array_filter(array_map('trim', explode(',', $options)), fn ($value) => $value !== ''));
        }

        return [];
    }

    public function questions(Request $request)
    {
        $questions = Game::where('type', 'guess_part')
            ->where('status', 'active')
            ->orderBy('id')
            ->get();

        $payload = $questions
            ->map(function (Game $game) {
                return [
                    'id' => $game->id,
                    'title' => $game->title,
                    'description' => $game->description,
                    'question' => $game->question,
                    'answer' => $game->answer,
                    'options' => $this->parseOptions($game->options),
                    'game_file' => $game->game_file,
                    'thumbnail' => $game->thumbnail,
                    'type' => $game->type,
                    'status' => $game->status,
                ];
            })
            ->filter(function (array $question) {
                return !empty($question['question'])
                    && !empty($question['answer'])
                    && count($question['options']) > 0;
            })
            ->values();

        return response()->json([
            'status' => 'success',
            'questions' => $payload,
        ]);
    }

    public function submit(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'assessments' => 'required|array|min:1',
            'assessments.*.game_id' => 'required|integer',
            'assessments.*.user_answer' => 'nullable|string',
        ]);

        $assessments = collect($validated['assessments']);
        $questionIds = $assessments->pluck('game_id')->map(fn ($id) => (int) $id)->unique()->values();
        $questions = Game::whereIn('id', $questionIds)
            ->where('type', 'guess_part')
            ->get()
            ->keyBy('id');

        $correctCount = 0;
        $processedCount = 0;

        foreach ($assessments as $assessment) {
            $question = $questions->get((int) $assessment['game_id']);
            if (!$question) {
                continue;
            }

            $processedCount++;
            $userAnswer = trim((string) ($assessment['user_answer'] ?? ''));
            $isCorrect = mb_strtolower($userAnswer) === mb_strtolower(trim((string) $question->answer));

            UserAssessment::create([
                'user_id' => $user->id,
                'game_id' => $question->id,
                'user_answer' => $userAnswer,
                'is_correct' => $isCorrect,
            ]);

            if ($isCorrect) {
                $correctCount++;
            }
        }

        if ($processedCount === 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'No valid assessment questions were submitted.',
            ], 422);
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
            'total_questions' => $processedCount,
        ]);
    }
}
