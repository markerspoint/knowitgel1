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
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'game_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'question' => 'required|string|max:255',
                'answer' => 'required|string|max:255',
                'status' => 'required|in:active,inactive'
            ]);

            Log::info('Game upload started', [
                'title' => $request->title,
                'files' => $request->allFiles()
            ]);

            // Handle computer part image upload
            $gameFile = $request->file('game_file');
            $gameFileName = time() . '_' . $gameFile->getClientOriginalName();
            $gameFilePath = public_path('games/' . $gameFileName);
            
            if (!$gameFile->move(public_path('games'), $gameFileName)) {
                throw new \Exception('Failed to move computer part image');
            }

            Log::info('Computer part image uploaded', ['path' => $gameFilePath]);

            // Handle thumbnail upload
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnailPath = public_path('thumbnails/' . $thumbnailName);
            
            if (!$thumbnail->move(public_path('thumbnails'), $thumbnailName)) {
                // Clean up game file if thumbnail upload fails
                if (file_exists($gameFilePath)) {
                    unlink($gameFilePath);
                }
                throw new \Exception('Failed to move thumbnail file');
            }

            Log::info('Thumbnail uploaded', ['path' => $thumbnailPath]);

            // Create game record
            $game = Game::create([
                'title' => $request->title,
                'description' => $request->description,
                'game_file' => 'games/' . $gameFileName,
                'thumbnail' => 'thumbnails/' . $thumbnailName,
                'question' => $request->question,
                'answer' => $request->answer,
                'status' => $request->status
            ]);

            Log::info('Game record created', ['game_id' => $game->id]);

            return redirect()->back()->with('success', 'Computer part game uploaded successfully!');
        } catch (\Exception $e) {
            Log::error('Game upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
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

            // Handle game file upload if new file is provided
            if ($request->hasFile('game_file')) {
                // Delete old file
                if (file_exists(public_path($game->game_file))) {
                    unlink(public_path($game->game_file));
                }
                
                $gameFile = $request->file('game_file');
                $gameFileName = time() . '_' . $gameFile->getClientOriginalName();
                $gameFile->move(public_path('games'), $gameFileName);
                $data['game_file'] = 'games/' . $gameFileName;
            }

            // Handle thumbnail upload if new thumbnail is provided
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail
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
            // Delete game file
            if (file_exists(public_path($game->game_file))) {
                unlink(public_path($game->game_file));
            }
            
            // Delete thumbnail
            if (file_exists(public_path($game->thumbnail))) {
                unlink(public_path($game->thumbnail));
            }
            
            $game->delete();
            return redirect()->back()->with('success', 'Game deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting game: ' . $e->getMessage());
        }
    }
} 