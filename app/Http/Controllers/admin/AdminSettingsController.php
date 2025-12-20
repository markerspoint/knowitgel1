<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Setting;

class AdminSettingsController extends Controller
{
    public function getGameSettings(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'settings' => [
                'qa_fps_enabled' => Setting::isEnabled('qa_fps_enabled'),
                'typergel1_enabled' => Setting::isEnabled('typergel1_enabled'),
            ],
        ]);
    }

    public function updateGameSettings(Request $request)
    {
        $request->validate([
            'qa_fps_enabled' => 'required|boolean',
            'typergel1_enabled' => 'required|boolean',
        ]);

        Setting::set('qa_fps_enabled', $request->input('qa_fps_enabled') ? '1' : '0');
        Setting::set('typergel1_enabled', $request->input('typergel1_enabled') ? '1' : '0');

        return response()->json([
            'status' => 'success',
            'message' => 'Game settings updated successfully.',
            'settings' => [
                'qa_fps_enabled' => Setting::isEnabled('qa_fps_enabled'),
                'typergel1_enabled' => Setting::isEnabled('typergel1_enabled'),
            ],
        ]);
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'The current password is incorrect.',
            ], 422);
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Password updated successfully.',
        ]);
    }
}
