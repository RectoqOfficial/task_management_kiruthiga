<?php
namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;

class SalaryController extends Controller
{
    public function index()
    {
        return view('employee.my-salary');
    }
}
