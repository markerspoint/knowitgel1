<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $user->load(['scores', 'completedLessons', 'assessments']);

        return response()->json([
            'status' => 'success',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'fname' => $user->fname,
                'lname' => $user->lname,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role,
                'profile_picture' => $user->profile_picture,
                'total_score' => $user->scores->sum('score') ?? 0,
                'games_played' => $user->scores->count() ?? 0,
                'lessons_completed' => $user->completedLessons->count() ?? 0,
                'has_completed_assessment' => $user->hasCompletedAssessment(),
            ]
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_profile_picture' => 'nullable|boolean',
        ]);

        try {
            Log::info('Admin profile update request', [
                'user_id' => $user->id,
                'payload' => $request->all(),
            ]);

            $user->fname = $request->input('fname');
            $user->lname = $request->input('lname');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->name = trim($request->input('fname') . ' ' . $request->input('lname'));

            if ($request->has('remove_profile_picture') && $request->boolean('remove_profile_picture')) {
                if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                    @unlink(public_path($user->profile_picture));
                }
                $user->profile_picture = null;
            } elseif ($request->hasFile('profile_picture')) {
                if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                    @unlink(public_path($user->profile_picture));
                }

                $file = $request->file('profile_picture');
                $fileName = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('profile_pictures'), $fileName);
                $user->profile_picture = 'profile_pictures/' . $fileName;
            }

            $dirtyBeforeSave = $user->getDirty();

            $saved = $user->save();

            Log::info('Admin profile save result', [
                'user_id' => $user->id,
                'saved' => $saved,
                'dirty_before_save' => $dirtyBeforeSave,
            ]);

            if (!$saved) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to update profile. Please try again.',
                ], 500);
            }

            $user->refresh();

            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'fname' => $user->fname,
                    'lname' => $user->lname,
                    'username' => $user->username,
                    'email' => $user->email,
                    'role' => $user->role,
                    'profile_picture' => $user->profile_picture,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Exception updating admin profile', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating your profile.',
            ], 500);
        }
    }
}


