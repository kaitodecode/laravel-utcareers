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
        
        $credentials = [
            $field => $login,
            'password' => $password
        ];

        if (!auth()->attempt($credentials)) {
            return back()->withErrors([
                'login' => 'The provided credentials do not match our records.',
            ]);
        }
        
        $user = User::where($field, $login)->first();
        auth()->login($user);
        
        if($user->role == "admin"){
            return redirect()->intended('/admin/dashboard')->with('success', 'Login successful');
        }
        if($user->role == "pelamar"){
            return redirect()->intended('/pelamar/dashboard')->with('success', 'Login successful');
        }
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
