<?php

namespace App\Http\Controllers\Employee;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaveController extends Controller
{
    // Display employee leave requests and balances
    public function index()
    {
        // Ensure the employee is authenticated
        if (!Auth::guard('employee')->check()) {
            return redirect()->route('employee.login')->with('error', 'Please log in to view your leave requests.');
        }

        // Retrieve the employee (currently authenticated user)
        $employee = Auth::guard('employee')->user();

        // Calculate the leave balances
        $vacationLeaveBalance = $employee->vacationLeaveBalance();
        $sickLeaveBalance = $employee->sickLeaveBalance();

        // Retrieve the leave requests for the authenticated employee
        $leaveRequests = LeaveRequest::where('employee_id', $employee->id)->get();

        // Retrieve all leave types for the leave request form
        $leaveTypes = LeaveType::all();

        // Return the view with the necessary data
        return view('employee.leave', compact('leaveRequests', 'vacationLeaveBalance', 'sickLeaveBalance', 'leaveTypes'));
    }
public function store(Request $request)
{
    $request->validate([
        'leave_type_id' => 'required|exists:leave_types,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'notes' => 'nullable|string',
    ]);

    $employee = Auth::guard('employee')->user();
    $leaveType = LeaveType::findOrFail($request->leave_type_id);
    $leaveDays = Carbon::parse($request->start_date)->diffInDays(Carbon::parse($request->end_date)) + 1;

    // Check leave balance before creating the request
    if ($leaveType->name == 'Vacation' && $employee->vacationLeaveBalance() < $leaveDays) {
        return $request->ajax()
            ? response()->json(['message' => 'You do not have enough vacation leave.'], 422)
            : redirect()->route('employee.leave.index')->with('error', 'You do not have enough vacation leave.');
    }

    if ($leaveType->name == 'Sick' && $employee->sickLeaveBalance() < $leaveDays) {
        return $request->ajax()
            ? response()->json(['message' => 'You do not have enough sick leave.'], 422)
            : redirect()->route('employee.leave.index')->with('error', 'You do not have enough sick leave.');
    }

    // Create the leave request
    $leaveRequest = LeaveRequest::create([
        'employee_id' => $employee->id,
        'leave_type_id' => $request->leave_type_id,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'status' => 'Pending', // Initially pending
        'notes' => $request->notes,
    ]);

    // If the request is approved later, update the balance
    if ($leaveRequest->status == 'Approved') {
        if ($leaveType->name == 'Vacation') {
            $employee->decrement('vacation_leave_balance', $leaveDays);
        } elseif ($leaveType->name == 'Sick') {
            $employee->decrement('sick_leave_balance', $leaveDays);
        }
    }

    $message = 'Leave request submitted successfully.';

    return $request->ajax()
        ? response()->json([
            'message' => $message,
            'leave_type' => $leaveType->name,
            'start_date' => $leaveRequest->start_date,
            'end_date' => $leaveRequest->end_date,
        ])
        : redirect()->route('employee.leave.index')->with('success', $message);
}
public function updateStatus($id, $status)
{
    $leaveRequest = LeaveRequest::findOrFail($id);
    $employee = $leaveRequest->employee;

    // Update the leave request status
    $leaveRequest->status = $status;
    $leaveRequest->save();

    // Update the balance if approved
    if ($status == 'Approved') {
        $leaveType = $leaveRequest->leaveType;
        $leaveDays = Carbon::parse($leaveRequest->start_date)->diffInDays(Carbon::parse($leaveRequest->end_date)) + 1;

        // Decrement balance when approved
        if ($leaveType->name == 'Vacation') {
            $employee->decrement('vacation_leave_balance', $leaveDays);
        } elseif ($leaveType->name == 'Sick') {
            $employee->decrement('sick_leave_balance', $leaveDays);
        }
    }

    return redirect()->route('employee.leave.index')->with('success', 'Leave request status updated successfully.');
}

}
