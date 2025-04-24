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
    public function index()
    {
        if (!Auth::guard('employee')->check()) {
            return redirect()->route('employee.login')->with('error', 'Please log in to view your leave requests.');
        }

        $employee = Auth::guard('employee')->user();

        $vacationLeaveBalance = $employee->vacationLeaveBalance();
        $sickLeaveBalance = $employee->sickLeaveBalance();
        $casualLeaveBalance = $employee->casualLeaveBalance(); // ✅ Added

        $leaveRequests = LeaveRequest::where('employee_id', $employee->id)->get();
        $leaveTypes = LeaveType::all();

        return view('employee.leave', compact(
            'leaveRequests',
            'vacationLeaveBalance',
            'sickLeaveBalance',
            'casualLeaveBalance', // ✅ Added
            'leaveTypes'
        ));
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

        // ✅ Leave Balance Checks
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

        if ($leaveType->name == 'Casual Leave' && $employee->casualLeaveBalance() < $leaveDays) {
            return $request->ajax()
                ? response()->json(['message' => 'You do not have enough casual leave.'], 422)
                : redirect()->route('employee.leave.index')->with('error', 'You do not have enough casual leave.');
        }

        $leaveRequest = LeaveRequest::create([
            'employee_id' => $employee->id,
            'leave_type_id' => $request->leave_type_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'Pending',
            'notes' => $request->notes,
        ]);

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

        if (!in_array($status, ['Approved', 'Rejected', 'Pending'])) {
            return redirect()->back()->with('error', 'Invalid status provided.');
        }

        if (in_array($leaveRequest->status, ['Approved', 'Rejected'])) {
            return redirect()->back()->with('error', 'This leave request has already been processed.');
        }

        $employee = $leaveRequest->employee;
        $leaveType = $leaveRequest->leaveType;
        $leaveDays = Carbon::parse($leaveRequest->start_date)->diffInDays(Carbon::parse($leaveRequest->end_date)) + 1;

        if ($status == 'Approved') {
            if ($leaveType->name == 'Vacation') {
                if ($employee->vacationLeaveBalance() < $leaveDays) {
                    return redirect()->back()->with('error', 'Insufficient vacation leave balance.');
                }
                $employee->decrement('vacation_leave_balance', $leaveDays);
            }

            if ($leaveType->name == 'Sick') {
                if ($employee->sickLeaveBalance() < $leaveDays) {
                    return redirect()->back()->with('error', 'Insufficient sick leave balance.');
                }
                $employee->decrement('sick_leave_balance', $leaveDays);
            }

            if ($leaveType->name == 'Casual Leave') {
                if ($employee->casualLeaveBalance() < $leaveDays) {
                    return redirect()->back()->with('error', 'Insufficient casual leave balance.');
                }
                $employee->decrement('casual_leave_balance', $leaveDays); // optional if you're tracking in DB
            }
            
        }

        $leaveRequest->status = $status;
        $leaveRequest->save();

        return redirect()->back()->with('success', "Leave request has been {$status}.");
    }
}
