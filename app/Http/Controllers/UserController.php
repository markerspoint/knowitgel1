<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'number' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);
    
        try {
            $user = User::create([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'username' => $request->username,
                'email' => $request->email,
                'number' => $request->number,
                'password' => Hash::make($request->password),
            ]);
    
            Log::info('User registered successfully: ' . $user->id);
    
            return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred during registration.');
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required'
        ]);
    
        $user = User::where('username', $request->username)->first();
    
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('dashboard'); 
        }
    
        return back()->with('error', 'Invalid username or password');
    }

    public function history()
    {
        $user = Auth::user();
        $history = $user->scores()->orderBy('created_at', 'desc')->get();
        
        return view('user.history', compact('history'));
    }
    
}
