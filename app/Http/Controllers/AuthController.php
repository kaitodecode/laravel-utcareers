<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            "login" => "required",
            "password" => "required",
        ]);

        $login = $request->input('login');
        $password = $request->input('password');
        
        // Determine if login is email or phone
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        
        // Find user first to check if exists
        $user = User::where($field, $login)->first();
        
        if (!$user) {
            return back()->withErrors([
                'login' => 'User not found.',
            ]);
        }

        // Attempt authentication with found user's credentials
        if (!auth()->attempt([$field => $login, 'password' => $password])) {
            return back()->withErrors([
                'login' => 'Invalid password.',
            ]);
        }

        // Set authenticated session
        auth()->login($user);
        
        // Redirect based on role
        if($user->role == "admin"){
            return redirect()->intended('/admin/dashboard')->with('success', 'Login successful');
        }
        if($user->role == "pelamar"){
            return redirect()->intended('/pelamar/dashboard')->with('success', 'Login successful');
        }

        // Fallback redirect if no role matches
        return redirect()->intended('/')->with('success', 'Login successful');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logout successful');
    }

    public function loginView()
    {
        return view('auth.login');
    }


}
