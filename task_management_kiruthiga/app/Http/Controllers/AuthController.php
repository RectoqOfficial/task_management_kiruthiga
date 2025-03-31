<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AuthController extends Controller
{
    // Show Login Page
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle Login Request
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return redirect()->back()->with('error', 'Invalid email or password');
        }

        // Login with 'admin' guard
        Auth::guard('admin')->login($admin);
        $request->session()->regenerate(); // Important to persist session

        // Ensure role exists
        if (!$admin->role) {
            Auth::guard('admin')->logout(); // Log out admin if no role
            return redirect()->route('login')->with('error', 'No role assigned. Contact Admin.');
        }

        // Debug Log: Check the assigned role
        \Log::info('Redirecting user...', ['role' => $admin->role->name]);

        // Redirect based on role
        $role = strtolower($admin->role->name);

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'employee') {
            return redirect()->route('employee.dashboard');
        } else {
            Auth::guard('admin')->logout();
            return redirect()->route('login')->with('error', 'Access Denied. Invalid Role.');
        }
    }

    // Handle Logout Request
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }
}
