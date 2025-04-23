<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SalaryController extends Controller
{
    public function index()
    {
        return view('admin.salary-details');
    }
}
