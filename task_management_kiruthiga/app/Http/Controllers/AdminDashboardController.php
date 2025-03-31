<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin'); // Ensure only authenticated admins can access
    }

    public function index()
    {
        // Log the authenticated admin
        Log::info('Authenticated Admin:', ['user' => Auth::guard('admin')->user()]);

        $departments = Department::with('roles')->get();
        return view('admin.dashboard', compact('departments'));
    }
}
