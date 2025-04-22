<?php
// app/Http/Controllers/Admin/LeaveController.php

namespace App\Http\Controllers\Admin;

use App\Models\LeaveRequest;
use App\Http\Controllers\Controller;

class LeaveController extends Controller
{
    public function index()
    {
        $leaveRequests = LeaveRequest::with('employee')->paginate(10);
        return view('admin.leave', compact('leaveRequests'));
    }

    public function approve($id)
    {
        $leave = LeaveRequest::find($id);
        $leave->status = 'Approved';
        $leave->save();
        return redirect()->route('admin.leave.index');
    }

    public function reject($id)
    {
        $leave = LeaveRequest::find($id);
        $leave->status = 'Rejected';
        $leave->save();
        return redirect()->route('admin.leave.index');
    }

  public function view($id)
{
    $leave = LeaveRequest::with('employee')->find($id);
    return response()->json(['leave' => $leave]);
}

}
