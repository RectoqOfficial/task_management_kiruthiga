<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::guard('admin')->attempt($credentials)) {
        $user = Auth::guard('admin')->user(); // ✅ Fetch authenticated user

        // Debugging check
        \Log::info("User authenticated: ", ['user' => $user]);

        if ($user->role->role == 'Admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role->role == 'Employee') {
            return redirect()->route('employee.dashboard');
        }
    }

    return redirect()->back()->with('error', 'Invalid email or password');
}

public function logout()
{
    Auth::guard('admin')->logout();
    return redirect()->route('login');
}

}
