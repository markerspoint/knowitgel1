<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        $games = Game::all();
        
        return view('admin.adminDashboard', compact('users', 'games'));
    }

    public function storeGame(Request $request)
    {
        try {
            $rules = [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'question' => 'required|string|max:255',
                'answer' => 'required|string|max:255',
                'type' => 'required|in:guess_part,qa',
                'status' => 'required|in:active,inactive'
            ];

            if ($request->type === 'guess_part') {
                $rules['game_file'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
            } else {
                $rules['options'] = 'required|string';
            }

            $request->validate($rules);

            // Handle thumbnail upload
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('thumbnails'), $thumbnailName);

            $gameData = [
                'title' => $request->title,
                'description' => $request->description,
                'thumbnail' => 'thumbnails/' . $thumbnailName,
                'question' => $request->question,
                'answer' => $request->answer,
                'type' => $request->type,
                'status' => $request->status
            ];

            if ($request->type === 'guess_part') {
                $gameFile = $request->file('game_file');
                $gameFileName = time() . '_' . $gameFile->getClientOriginalName();
                $gameFile->move(public_path('games'), $gameFileName);
                $gameData['game_file'] = 'games/' . $gameFileName;
            }

            if ($request->type === 'qa' && $request->options) {
                $options = array_map('trim', explode(',', $request->options));
                $gameData['options'] = json_encode($options);
            }

            Game::create($gameData);

            return redirect()->back()->with('success', 'Game uploaded successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error uploading game: ' . $e->getMessage());
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
            if (file_exists(public_path($game->game_file))) {
                unlink(public_path($game->game_file));
            }
            
            if (file_exists(public_path($game->thumbnail))) {
                unlink(public_path($game->thumbnail));
            }
            
            $game->delete();
            return redirect()->back()->with('success', 'Game deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting game: ' . $e->getMessage());
        }
    }

    public function showComputerParts()
    {
        $games = Game::where('type', 'guess_part')->where('status', 'active')->get();
        return view('computer_parts', compact('games'));
    }
}