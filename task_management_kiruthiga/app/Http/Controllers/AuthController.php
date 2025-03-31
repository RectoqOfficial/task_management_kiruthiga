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

    Auth::login($admin); // Logging in the user

    \Log::info('Login Successful', ['user' => Auth::user()]); // Debugging

    if ($admin->role) {
        \Log::info('User Role:', ['role' => $admin->role->name]);
    }

    // Redirect based on role
    if (strtolower($admin->role->name) === 'admin') {
        return redirect()->route('admin.dashboard'); 
    } elseif (strtolower($admin->role->name) === 'employee') {
        return redirect()->route('employee.dashboard');
    } else {
        Auth::logout();
        return redirect()->route('login')->with('error', 'Access Denied. Invalid Role.');
    }
}





    // Handle Logout Request
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
