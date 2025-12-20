<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $user = User::where('username', $credentials['username'])->first();

            if (!$user || !Hash::check($credentials['password'], $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid credentials. Please check your username and password.',
                ], 422);
            }

            if ($user->is_disabled) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Your account has been disabled. Please contact support.',
                ], 403);
            }

            Auth::login($user);
            $request->session()->regenerate();

            $redirect = $user->role === 'admin'
                ? '/admin/dashboard'
                : ($user->hasCompletedAssessment() ? '/user/dashboard' : '/assessment');

            return response()->json([
                'status' => 'success',
                'message' => 'Login successful.',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'fname' => $user->fname,
                        'lname' => $user->lname,
                        'username' => $user->username,
                        'email' => $user->email,
                        'role' => $user->role,
                    ],
                    'redirect' => $redirect,
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Login error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during login. Please try again.',
                'debug' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }


    public function register(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'number' => 'required|string|max:15',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
    
        try {
            $user = User::create([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'username' => $request->username,
                'email' => $request->email,
                'number' => $request->number,
                'password' => Hash::make($request->password),
                'name' => trim($request->fname . ' ' . $request->lname),
                'role' => 'user'
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Registration successful! Please log in to access your dashboard.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Registration error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during registration. Please try again.',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully.'
        ]);
    }
}