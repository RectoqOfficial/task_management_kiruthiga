<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Employee; // Import Employee model
use Illuminate\Support\Facades\Log;
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
          Log::info('Session before login: ' . session()->getId());
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Try Admin Login First
        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            Auth::guard('admin')->login($admin);
            $request->session()->regenerate();
    // ✅ Log session after successful admin login
        Log::info('Session after login (admin): ' . session()->getId());
            if (!$admin->role) {
                Auth::guard('admin')->logout();
                return redirect()->route('login')->with('error', 'No role assigned. Contact Admin.');
            }

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

        // If Admin Login Fails, Try Employee Login
       $employee = Employee::where('email_id', $request->email)->first();


        if ($employee && Hash::check($request->password, $employee->password)) {
            Auth::guard('employee')->login($employee);
            $request->session()->regenerate();
 // ✅ Log session after successful employee login
        Log::info('Session after login (employee): ' . session()->getId());

            return redirect()->route('employee.dashboard');
        }

        // If neither Admin nor Employee matches, return an error
        return redirect()->back()->with('error', 'Invalid email or password');
     
    }

    // Handle Logout Request
    public function logout()
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('employee')->check()) {
            Auth::guard('employee')->logout();
        }

        return redirect()->route('login');
    }
}
