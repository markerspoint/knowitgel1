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
        $users = User::all();
        $games = Game::all();
        $lessons = Lesson::all();
        
        return view('admin.adminDashboard', compact('users', 'games', 'lessons'));
    }

    public function storeLesson(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'content' => 'required|string',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'required|in:active,inactive'
            ]);

            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('thumbnails'), $thumbnailName);

            Lesson::create([
                'title' => $request->title,
                'description' => $request->description,
                'content' => $request->content,
                'thumbnail' => 'thumbnails/' . $thumbnailName,
                'status' => $request->status
            ]);

            return redirect()->back()->with('success', 'Lesson created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating lesson: ' . $e->getMessage());
        }
    }
    public function storeGame(Request $request)
    {
        try {
            $rules = [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'type' => 'required|in:guess_part,qa,lesson',
                'status' => 'required|in:active,inactive'
            ];

            if ($request->type === 'guess_part') {
                $rules['game_file'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
                $rules['question'] = 'required|string|max:255';
                $rules['answer'] = 'required|string|max:255';
            } else if ($request->type === 'qa') {
                $rules['options'] = 'required|string';
                $rules['question'] = 'required|string|max:255';
                $rules['answer'] = 'required|string|max:255';
            }

            $request->validate($rules);

            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('thumbnails'), $thumbnailName);

            $gameData = [
                'title' => $request->title,
                'description' => $request->description,
                'thumbnail' => 'thumbnails/' . $thumbnailName,
                'type' => $request->type,
                'status' => $request->status
            ];

            if ($request->type === 'guess_part') {
                $gameFile = $request->file('game_file');
                $gameFileName = time() . '_' . $gameFile->getClientOriginalName();
                $gameFile->move(public_path('games'), $gameFileName);
                $gameData['game_file'] = 'games/' . $gameFileName;
                $gameData['question'] = $request->question;
                $gameData['answer'] = $request->answer;
            }

            if ($request->type === 'qa' && $request->options) {
                $options = array_map('trim', explode(',', $request->options));
                $gameData['options'] = json_encode($options);
                $gameData['question'] = $request->question;
                $gameData['answer'] = $request->answer;
            }

            Game::create($gameData);

            return redirect()->back()->with('success', 'Item uploaded successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error uploading item: ' . $e->getMessage());
        }
    }

    public function updateGame(Request $request, Game $game)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'game_file' => 'nullable|file|mimes:html,js,css,json|max:10240',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive'
        ]);

        try {
            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status
            ];

            if ($request->hasFile('game_file')) {
                if (file_exists(public_path($game->game_file))) {
                    unlink(public_path($game->game_file));
                }
                
                $gameFile = $request->file('game_file');
                $gameFileName = time() . '_' . $gameFile->getClientOriginalName();
                $gameFile->move(public_path('games'), $gameFileName);
                $data['game_file'] = 'games/' . $gameFileName;
            }
            if ($request->hasFile('thumbnail')) {
                if (file_exists(public_path($game->thumbnail))) {
                    unlink(public_path($game->thumbnail));
                }
                
                $thumbnail = $request->file('thumbnail');
                $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
                $thumbnail->move(public_path('thumbnails'), $thumbnailName);
                $data['thumbnail'] = 'thumbnails/' . $thumbnailName;
            }

            $game->update($data);

            return redirect()->back()->with('success', 'Game updated successfully!');
        } catch (\Exception $e) {
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
            return redirect()->back()->with('success', 'Game deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting game: ' . $e->getMessage());
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
        return redirect()->back()->with('success', "User {$user->username} has been {$action}.");
    }

    public function deleteUser(User $user)
    {
         try {
             $user->delete();
             return redirect()->back()->with('success', 'User deleted successfully.');
         } catch (\Exception $e) {
             return redirect()->back()->with('error', 'Failed to delete user.');
         }
    }
}