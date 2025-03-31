<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensure only authenticated users can access
    }

    public function index()
    {
        // Debugging Session and Authenticated User
        Log::info('Session at Dashboard:', session()->all());
        Log::info('Authenticated User:', ['user' => Auth::user()]);

        $departments = Department::with('roles')->get();
        return view('admin.dashboard', compact('departments'));
    }
}
