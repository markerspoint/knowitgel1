<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'login_type' => 'required|in:user,admin'
        ]);

        $guard = $credentials['login_type'] === 'admin' ? 'admin' : 'web';
        
        try {
            if (Auth::guard($guard)->attempt([
                'username' => $credentials['username'],
                'password' => $credentials['password']
            ])) {
                $request->session()->regenerate();
                
                if ($guard === 'admin') {
                    $admin = Auth::guard('admin')->user();
                    if ($admin->isSuperAdmin()) {
                        return redirect()->route('admin.dashboard')
                            ->with('success', 'Welcome back, Super Admin!');
                    }
                    return redirect()->route('admin.dashboard')
                        ->with('success', 'Welcome back, Admin!');
                }
                
                return redirect()->route('dashboard')
                    ->with('success', 'Welcome back!');
            }

            return back()
                ->withInput($request->only('username', 'login_type'))
                ->with('error', 'Invalid credentials. Please check your username and password.');
        } catch (\Exception $e) {
            return back()
                ->withInput($request->only('username', 'login_type'))
                ->with('error', 'An error occurred during login. Please try again.');
        }
    }

    public function showRegister()
    {
        return view('Register');
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
                'password' => Hash::make($request->password)
            ]);
    
            // Redirect to the login page with a success message
            return redirect()->route('login')->with('success', 'Registration successful! Please log in to access your dashboard.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'An error occurred during registration. Please try again.');
        }
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}