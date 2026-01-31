<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\UserAssessment;
use App\Models\Score;

class AssessmentController extends Controller
{
    private function getDefaultQuestions()
    {
        return [
            [
                'id' => 'def_1',
                'title' => 'Network Protocol',
                'question' => 'Which protocol is primarily used for securely logging into a remote server over a network?',
                'options' => ['FTP', 'SSH', 'SMTP', 'HTTP'],
                'answer' => 'SSH',
                'description' => 'Secure shell protocol for remote access.',
            ],
            [
                'id' => 'def_2',
                'title' => 'Web Infrastructure',
                'question' => 'What is the primary purpose of a Load Balancer in a high-traffic web environment?',
                'options' => [
                    'To store long-term backups of the database',
                    'To encrypt incoming data packets',
                    'To act as a physical cooling system for the rack',
                    'To distribute incoming network traffic across multiple servers'
                ],
                'answer' => 'To distribute incoming network traffic across multiple servers',
                'description' => 'Managing traffic across multiple servers.',
            ],
            [
                'id' => 'def_3',
                'title' => 'Development Tools',
                'question' => 'Which of these is a \'Version Control System\' used by developers to track changes in code?',
                'options' => ['Docker', 'Apache', 'Git', 'Kubernetes'],
                'answer' => 'Git',
                'description' => 'System for tracking changes in source code.',
            ]
        ];
    }

    public function questions(Request $request)
    {
        $questions = $this->getDefaultQuestions();

        return response()->json([
            'status' => 'success',
            'questions' => array_map(function ($q) {
                return [
                    'id' => $q['id'],
                    'title' => $q['title'],
                    'description' => $q['description'],
                    'question' => $q['question'],
                    'answer' => $q['answer'],
                    'options' => $q['options'],
                    'type' => 'default_assessment',
                    'status' => 'active'
                ];
            }, $questions)
        ]);
    }

    public function submit(Request $request)
    {
        $user = $request->user();
        $assessments = $request->input('assessments', []);
        $defaultQuestions = collect($this->getDefaultQuestions());

        $correctCount = 0;

        foreach ($assessments as $assessment) {
            $questionId = $assessment['game_id'] ?? null;
            $isCorrect = false;

            // Check if it's a default question
            $defaultQ = $defaultQuestions->firstWhere('id', $questionId);
            if ($defaultQ) {
                $isCorrect = (trim(strtolower($assessment['user_answer'])) === trim(strtolower($defaultQ['answer'])));
                
                // We don't save to UserAssessment since it requires a real game_id (foreign key)
                // If the user wants to keep track of these, we would need to modify the schema.
                // For now, we will just count the score.
                if ($isCorrect) {
                    $correctCount++;
                }
            } else {
                // Fallback for real games if any
                $game = Game::find($questionId);
                if ($game) {
                    $isCorrect = $assessment['is_correct'];
                    UserAssessment::create([
                        'user_id' => $user->id,
                        'game_id' => $game->id,
                        'user_answer' => $assessment['user_answer'],
                        'is_correct' => $isCorrect
                    ]);

                    if ($isCorrect) {
                        $correctCount++;
                    }
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
