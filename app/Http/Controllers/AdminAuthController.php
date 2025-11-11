<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AdminAuthController extends Controller
{
    public function showLoginForm() {
        return view('content.admin.login');
    }

     public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // ✅ check if remember box ticked

        if (Auth::attempt($credentials)) {

        //     if (Auth::user()->is_admin == 1) {
        //         return redirect()->route('dashboard-analytics');
        //     }

        if (Auth::attempt(array_merge($credentials, ['is_admin' => 1]), $remember)) {
            return redirect()->route('dashboard-analytics');
        }

            Auth::logout();
            return back()->with('error', 'You are not an admin.');
        }

        return back()->with('error', 'Invalid login details.');
    }

    public function showRegisterForm() {
        return view('content.admin.register');
    }

    public function register(Request $request) {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => 0, // ✅ Always User/Agent
        ]);

        Auth::login($user);
        return redirect()->route('admin.login');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    
    // Forgot Password Page
    public function forgotPassword()
    {
        return view('content.admin.forgot-password');
    }

    // Send Reset Link
    public function sendResetLink(Request $request)
    {
      
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));
        
        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Reset link sent!')
            : back()->with('error', 'Email not found');
    }

}
