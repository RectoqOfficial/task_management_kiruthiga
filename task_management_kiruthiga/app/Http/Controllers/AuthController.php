<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminDetail; // Import the model

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Renders login form
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user(); // Get logged-in user
            
            // Redirect based on role
            if ($user->role_id == 1) { // Admin
                return redirect()->route('admin.dashboard');
            } elseif ($user->role_id == 2) { // Employee
                return redirect()->route('employee.dashboard');
            }
        }

        return redirect()->back()->with('error', 'Invalid email or password.');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }
}
