<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Facades\File;

class AdminAssessmentController extends Controller
{
    private function convertToBytes($value)
    {
        $value = trim($value);
        $last = strtolower($value[strlen($value) - 1]);
        $value = (int) $value;
        
        switch ($last) {
            case 'g':
                $value *= 1024;
            case 'm':
                $value *= 1024;
            case 'k':
                $value *= 1024;
        }
        
        return $value;
    }

    public function index(Request $request)
    {
        $questions = Game::where('type', 'guess_part')->get();

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
                    'game_file' => $game->game_file ? asset($game->game_file) : null,
                    'thumbnail' => $game->thumbnail ? asset($game->thumbnail) : null,
                    'type' => $game->type,
                    'status' => $game->status
                ];
            })
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'question' => 'required|string',
            'answer' => 'required|string',
            'options' => 'required|string',
            'status' => 'required|in:active,inactive'
        ];

        $request->validate($rules);

        $gameFile = $request->file('game_file');
        
        if (!$gameFile) {
            return response()->json([
                'status' => 'error',
                'message' => 'Image is required.',
                'errors' => ['game_file' => ['Please upload an image for this question.']]
            ], 422);
        }
        
        if (!$gameFile->isValid()) {
            $errorMessage = 'File upload failed. ';
            $uploadMaxSize = ini_get('upload_max_filesize');
            $postMaxSize = ini_get('post_max_size');
            
            switch ($gameFile->getError()) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $errorMessage .= 'File is too large. ';
                    if ($uploadMaxSize || $postMaxSize) {
                        $maxAllowed = min(
                            $this->convertToBytes($uploadMaxSize),
                            $this->convertToBytes($postMaxSize)
                        );
                        $maxAllowedMB = round($maxAllowed / (1024 * 1024), 2);
                        $errorMessage .= "Server limit is {$maxAllowedMB}MB. Please use a smaller image.";
                    } else {
                        $errorMessage .= 'Maximum file size is 10MB. Please use a smaller image.';
                    }
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $errorMessage .= 'File was only partially uploaded. Please try again.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $errorMessage .= 'No file was uploaded.';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $errorMessage .= 'Missing temporary folder. Please contact administrator.';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $errorMessage .= 'Failed to write file to disk. Please try again.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $errorMessage .= 'File upload stopped by extension. Please contact administrator.';
                    break;
                default:
                    $errorMessage .= 'Please ensure the file is valid and under 10MB.';
            }
            
            return response()->json([
                'status' => 'error',
                'message' => $errorMessage,
                'errors' => ['game_file' => [$errorMessage]]
            ], 422);
        }

        $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
        $maxSize = 10240;

        if (!in_array($gameFile->getMimeType(), $allowedMimes)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid file type. Only JPEG, PNG, JPG, GIF, and WEBP images are allowed.',
                'errors' => ['game_file' => ['Invalid file type. Only image files are allowed.']]
            ], 422);
        }

        if ($gameFile->getSize() > $maxSize * 1024) {
            return response()->json([
                'status' => 'error',
                'message' => 'File is too large. Maximum file size is 10MB.',
                'errors' => ['game_file' => ['File size exceeds the maximum limit of 10MB.']]
            ], 422);
        }

        $options = array_map('trim', explode(',', $request->input('options')));

        $game = new Game();
        $game->title = $request->input('title');
        $game->description = $request->input('description');
        $game->question = $request->input('question');
        $game->answer = $request->input('answer');
        $game->options = json_encode($options);
        $game->type = 'guess_part';
        $game->status = $request->input('status');

            $gameFileName = time() . '_' . $gameFile->getClientOriginalName();
        
        $gamesPath = public_path('games');
        if (!File::exists($gamesPath)) {
            File::makeDirectory($gamesPath, 0755, true);
        }
        
        if (!$gameFile->move($gamesPath, $gameFileName)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save file. Please try again.',
                'errors' => ['game_file' => ['Failed to save the uploaded file.']]
            ], 422);
        }

        $game->game_file = 'games/' . $gameFileName;
        $game->thumbnail = 'games/' . $gameFileName;

        $game->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Assessment question created successfully',
            'question' => [
                'id' => $game->id,
                'title' => $game->title,
                'description' => $game->description,
                'question' => $game->question,
                'answer' => $game->answer,
                'options' => $game->options,
                'game_file' => $game->game_file ? asset($game->game_file) : null,
                'thumbnail' => $game->thumbnail ? asset($game->thumbnail) : null,
                'type' => $game->type,
                'status' => $game->status
            ]
        ]);
    }

    public function update(Request $request, $game)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'question' => 'required|string',
            'answer' => 'required|string',
            'options' => 'required|string',
            'status' => 'required|in:active,inactive'
        ];

        $request->validate($rules);

        $gameModel = Game::findOrFail($game);
        $options = array_map('trim', explode(',', $request->input('options')));

        $gameModel->title = $request->input('title');
        $gameModel->description = $request->input('description');
        $gameModel->question = $request->input('question');
        $gameModel->answer = $request->input('answer');
        $gameModel->options = json_encode($options);
        $gameModel->status = $request->input('status');

        if ($request->hasFile('game_file')) {
            $gameFile = $request->file('game_file');
            
            if (!$gameFile->isValid()) {
                $errorMessage = 'File upload failed. ';
                $uploadMaxSize = ini_get('upload_max_filesize');
                $postMaxSize = ini_get('post_max_size');
                
                switch ($gameFile->getError()) {
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        $errorMessage .= 'File is too large. ';
                        if ($uploadMaxSize || $postMaxSize) {
                            $maxAllowed = min(
                                $this->convertToBytes($uploadMaxSize),
                                $this->convertToBytes($postMaxSize)
                            );
                            $maxAllowedMB = round($maxAllowed / (1024 * 1024), 2);
                            $errorMessage .= "Server limit is {$maxAllowedMB}MB. Please use a smaller image.";
                        } else {
                            $errorMessage .= 'Maximum file size is 10MB. Please use a smaller image.';
                        }
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $errorMessage .= 'File was only partially uploaded. Please try again.';
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        $errorMessage .= 'No file was uploaded.';
                        break;
                    case UPLOAD_ERR_NO_TMP_DIR:
                        $errorMessage .= 'Missing temporary folder. Please contact administrator.';
                        break;
                    case UPLOAD_ERR_CANT_WRITE:
                        $errorMessage .= 'Failed to write file to disk. Please try again.';
                        break;
                    case UPLOAD_ERR_EXTENSION:
                        $errorMessage .= 'File upload stopped by extension. Please contact administrator.';
                        break;
                    default:
                        $errorMessage .= 'Please ensure the file is valid and under 10MB.';
                }
                
                return response()->json([
                    'status' => 'error',
                    'message' => $errorMessage,
                    'errors' => ['game_file' => [$errorMessage]]
                ], 422);
            }

            $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
            $maxSize = 10240;

            if (!in_array($gameFile->getMimeType(), $allowedMimes)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid file type. Only JPEG, PNG, JPG, GIF, and WEBP images are allowed.',
                    'errors' => ['game_file' => ['Invalid file type. Only image files are allowed.']]
                ], 422);
            }

            if ($gameFile->getSize() > $maxSize * 1024) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File is too large. Maximum file size is 10MB.',
                    'errors' => ['game_file' => ['File size exceeds the maximum limit of 10MB.']]
                ], 422);
            }

            if ($gameModel->game_file && file_exists(public_path($gameModel->game_file))) {
                unlink(public_path($gameModel->game_file));
            }
            
            $gameFileName = time() . '_' . $gameFile->getClientOriginalName();
            
            $gamesPath = public_path('games');
            if (!File::exists($gamesPath)) {
                File::makeDirectory($gamesPath, 0755, true);
            }
            
            if (!$gameFile->move($gamesPath, $gameFileName)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to save file. Please try again.',
                    'errors' => ['game_file' => ['Failed to save the uploaded file.']]
                ], 422);
            }

            $gameModel->game_file = 'games/' . $gameFileName;
            $gameModel->thumbnail = 'games/' . $gameFileName;
        }

        $gameModel->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Assessment question updated successfully',
            'question' => [
                'id' => $gameModel->id,
                'title' => $gameModel->title,
                'description' => $gameModel->description,
                'question' => $gameModel->question,
                'answer' => $gameModel->answer,
                'options' => $gameModel->options,
                'game_file' => $gameModel->game_file ? asset($gameModel->game_file) : null,
                'thumbnail' => $gameModel->thumbnail ? asset($gameModel->thumbnail) : null,
                'type' => $gameModel->type,
                'status' => $gameModel->status
            ]
        ]);
    }

    public function destroy(Request $request, $game)
    {
        $gameModel = Game::findOrFail($game);

        if ($gameModel->game_file && file_exists(public_path($gameModel->game_file))) {
            unlink(public_path($gameModel->game_file));
        }

        if ($gameModel->thumbnail && file_exists(public_path($gameModel->thumbnail))) {
            unlink(public_path($gameModel->thumbnail));
        }

        $gameModel->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Assessment question deleted successfully'
        ]);
    }
}
