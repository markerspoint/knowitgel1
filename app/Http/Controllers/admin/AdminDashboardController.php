<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Game;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminDashboardController extends Controller
{
    public function index()
    {
        if (request()->expectsJson()) {
            $users = User::all();
            $games = Game::all();
            $lessons = Lesson::all();
            
            return response()->json([
                'status' => 'success',
                'users' => $users,
                'games' => $games,
                'lessons' => $lessons,
            ]);
        }
        
        return redirect('/admin/dashboard');
    }

    public function storeLesson(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'content' => 'required|string',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'required|in:active,inactive'
            ]);

            $lessonData = [
                'title' => $request->title,
                'description' => $request->description,
                'content' => $request->content,
                'status' => $request->status,
                'thumbnail' => null
            ];

            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
                $thumbnail->move(public_path('thumbnails'), $thumbnailName);
                $lessonData['thumbnail'] = 'thumbnails/' . $thumbnailName;
            }

            $lesson = Lesson::create($lessonData);

            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Lesson created successfully!',
                    'lesson' => $lesson
                ]);
            }

            return redirect()->back()->with('success', 'Lesson created successfully!');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error creating lesson: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Error creating lesson: ' . $e->getMessage());
        }
    }
    public function storeGame(Request $request)
    {
        try {
            $rules = [
                'type' => 'required|in:guess_part,qa,lesson,typergel',
                'status' => 'required|in:active,inactive',
            ];

            if ($request->type === 'guess_part') {
                $rules['title'] = 'required|string|max:255';
                $rules['description'] = 'required|string';
                $rules['game_file'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
                $rules['question'] = 'required|string|max:255';
                $rules['answer'] = 'required|string|max:255';
            }

            if ($request->type === 'qa') {
                $rules['title'] = 'required|string|max:255';
                $rules['description'] = 'required|string';
                $rules['options'] = 'required|string';
                $rules['question'] = 'required|string|max:255';
                $rules['answer'] = 'required|string|max:255';
            }

            if ($request->type === 'typergel') {
                $rules['question'] = [
                    'required',
                    'string',
                    'max:255',
                    function ($attribute, $value, $fail) {
                        $exists = Game::where('type', 'typergel')
                            ->whereRaw('LOWER(question) = ?', [strtolower(trim($value))])
                            ->exists();
                        if ($exists) {
                            $fail('This word or phrase already exists in TyperGel1.');
                        }
                    }
                ];
            }

            $request->validate($rules);

            $gameData = [
                'type' => $request->type,
                'status' => $request->status,
                'thumbnail' => 'thumbnails/default-thumbnail.png',
            ];

            if ($request->type === 'guess_part') {
                $gameData['title'] = $request->title;
                $gameData['description'] = $request->description;
                $gameFile = $request->file('game_file');
                $gameFileName = time() . '_' . $gameFile->getClientOriginalName();
                $gameFile->move(public_path('games'), $gameFileName);
                $gameData['game_file'] = 'games/' . $gameFileName;
                $gameData['question'] = $request->question;
                $gameData['answer'] = $request->answer;
            }

            if ($request->type === 'qa' && $request->options) {
                $gameData['title'] = $request->title;
                $gameData['description'] = $request->description;
                $options = array_map('trim', explode(',', $request->options));
                $gameData['options'] = json_encode($options);
                $gameData['question'] = $request->question;
                $gameData['answer'] = $request->answer;
            }

            if ($request->type === 'typergel') {
                $question = $request->question;
                $gameData['title'] = 'TyperGel1: ' . $question;
                $gameData['description'] = 'Typing practice word: ' . $question;
                $gameData['question'] = $question;
                $gameData['answer'] = null;
                $gameData['options'] = null;
            }

            $game = Game::create($gameData);

            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Item uploaded successfully!',
                    'game' => $game
                ]);
            }

            return redirect()->back()->with('success', 'Item uploaded successfully!');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error uploading item: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Error uploading item: ' . $e->getMessage());
        }
    }

    public function updateGame(Request $request, Game $game)
    {
        $rules = [
            'status' => 'required|in:active,inactive'
        ];

        if ($game->type === 'typergel') {
            $rules['question'] = [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($game) {
                    $exists = Game::where('type', 'typergel')
                        ->where('id', '!=', $game->id)
                        ->whereRaw('LOWER(question) = ?', [strtolower(trim($value))])
                        ->exists();
                    if ($exists) {
                        $fail('This word or phrase already exists in TyperGel1.');
                    }
                }
            ];
        } else {
            $rules['title'] = 'required|string|max:255';
            $rules['description'] = 'required|string';
            $rules['game_file'] = 'nullable|file|mimes:html,js,css,json|max:10240';
            $rules['thumbnail'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $request->validate($rules);

        try {
            if ($game->type === 'typergel') {
                $question = $request->question;
                $data = [
                    'title' => 'TyperGel1: ' . $question,
                    'description' => 'Typing practice word: ' . $question,
                    'question' => $question,
                    'status' => $request->status
                ];
            } else {
                $data = [
                    'title' => $request->title,
                    'description' => $request->description,
                    'status' => $request->status
                ];

                if ($request->hasFile('game_file')) {
                    if ($game->game_file && file_exists(public_path($game->game_file))) {
                        unlink(public_path($game->game_file));
                    }
                    
                    $gameFile = $request->file('game_file');
                    $gameFileName = time() . '_' . $gameFile->getClientOriginalName();
                    $gameFile->move(public_path('games'), $gameFileName);
                    $data['game_file'] = 'games/' . $gameFileName;
                }
                if ($request->hasFile('thumbnail')) {
                    if ($game->thumbnail && file_exists(public_path($game->thumbnail))) {
                        unlink(public_path($game->thumbnail));
                    }
                    
                    $thumbnail = $request->file('thumbnail');
                    $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
                    $thumbnail->move(public_path('thumbnails'), $thumbnailName);
                    $data['thumbnail'] = 'thumbnails/' . $thumbnailName;
                }
            }

            $game->update($data);

            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Game updated successfully!',
                    'game' => $game
                ]);
            }

            return redirect()->back()->with('success', 'Game updated successfully!');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error updating game: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Error updating game: ' . $e->getMessage());
        }
    }

    public function deleteGame(Game $game)
    {
        try {
            if ($game->game_file && file_exists(public_path($game->game_file))) {
                unlink(public_path($game->game_file));
            }
            
            if ($game->thumbnail && file_exists(public_path($game->thumbnail))) {
                unlink(public_path($game->thumbnail));
            }
            
            $game->delete();
            
            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Game deleted successfully!'
                ]);
            }
            
            return redirect()->back()->with('success', 'Game deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting game: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error deleting game: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error deleting game: ' . $e->getMessage());
        }
    }

    public function showComputerParts()
    {
        $games = Game::where('type', 'guess_part')->where('status', 'active')->get();
        return view('computer_parts', compact('games'));
    }

    public function updateUser(Request $request, User $user)
    {
        try {
            $request->validate([
                'fname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'username' => 'required|string|unique:users,username,'.$user->id
            ]);

            $user->update($request->all());
            return redirect()->back()->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating user: '.$e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified lesson.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\View\View
     */
    public function editLesson(Lesson $lesson)
    {
        return view('admin.lessons.edit', compact('lesson'));
    }

    /**
     * Update the specified lesson in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateLesson(Request $request, Lesson $lesson)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'content' => 'required|string',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'status' => 'required|in:active,inactive',
            ]);

            if ($request->hasFile('thumbnail')) {
                if ($lesson->thumbnail && Storage::disk('public')->exists($lesson->thumbnail)) {
                    Storage::disk('public')->delete($lesson->thumbnail);
                }
                $thumbnailPath = $request->file('thumbnail')->store('lessons/thumbnails', 'public');
                $validatedData['thumbnail'] = $thumbnailPath;
            } else {
                 unset($validatedData['thumbnail']);
            }


            $lesson->update($validatedData);

            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Lesson updated successfully!',
                    'lesson' => $lesson
                ]);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Lesson updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
             Log::error('Lesson update validation failed: ' . $e->getMessage());
             return redirect()->back()->withErrors($e->errors())->withInput()->with('error', 'Validation failed. Please check the form.');
        } catch (\Exception $e) {
            Log::error('Error updating lesson: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating lesson: ' . $e->getMessage())->withInput();
        }
    }

    public function toggleStatus(User $user)
    {
        $user->is_disabled = !$user->is_disabled;
        $user->save();

        $action = $user->is_disabled ? 'disabled' : 'enabled';
        
        if (request()->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => "User {$user->username} has been {$action}.",
                'user' => $user
            ]);
        }
        
        return redirect()->back()->with('success', "User {$user->username} has been {$action}.");
    }

    public function deleteUser(User $user)
    {
         try {
             $user->delete();
             
             if (request()->expectsJson()) {
                 return response()->json([
                     'status' => 'success',
                     'message' => 'User deleted successfully.'
                 ]);
             }
             
             return redirect()->back()->with('success', 'User deleted successfully.');
         } catch (\Exception $e) {
             if (request()->expectsJson()) {
                 return response()->json([
                     'status' => 'error',
                     'message' => 'Failed to delete user.'
                 ], 500);
             }
             return redirect()->back()->with('error', 'Failed to delete user.');
         }
    }

    public function deleteLesson(Lesson $lesson)
    {
        try {
            if ($lesson->thumbnail && file_exists(public_path($lesson->thumbnail))) {
                unlink(public_path($lesson->thumbnail));
            }
            
            $lesson->delete();
            
            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Lesson deleted successfully!'
                ]);
            }
            
            return redirect()->back()->with('success', 'Lesson deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting lesson: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error deleting lesson: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error deleting lesson: ' . $e->getMessage());
        }
    }
}