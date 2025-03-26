<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminDetail;

class AdminAuthController extends Controller
{
    // Show the Admin Login Page
    public function showLoginForm()
    {
        return view('auth.admin_login');
    }

    // Handle Admin Login
   public function login(Request $request) {
    $credentials = $request->only('email', 'password');

    $admin = AdminDetail::where('email', $credentials['email'])->first();

    if ($admin && Hash::check($credentials['password'], $admin->password)) {
        Auth::guard('admin')->login($admin); // Use the 'admin' guard
        return redirect()->route('admin.dashboard');
    }

    return back()->withErrors(['email' => 'Invalid credentials.']);
}

    // Redirect user based on their role
    public function authenticated(Request $request, $user)
    {
        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role == 'employee') {
            return redirect()->route('employee.dashboard');
        }
    }

    // Admin Dashboard View
 public function dashboard()
{
    $user = Auth::guard('admin')->user(); // Fetch the logged-in admin
    return view('admin.dashboard', compact('user')); // Pass user to view
}

    // Handle Admin Logout
   public function logout()
{
    Auth::guard('admin')->logout(); // ✅ Correct Guard
    return redirect()->route('admin.login');
}
}
