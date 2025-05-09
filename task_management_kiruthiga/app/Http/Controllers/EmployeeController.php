<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log; // Import Log class
use App\Models\Department;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class EmployeeController extends Controller
{
     // Display employee list page
    public function index()
    {
        // Fetch employees with their departments and roles
        $employees = Employee::with(['department', 'role'])->get();
        
        // Fetch all departments and roles for dropdown selection
        $departments = Department::all();
        $roles = Role::all();

        return view('admin.employee', compact('employees', 'departments', 'roles'));
    }

public function addEmployee(Request $request)
{
    $request->validate([
        'full_name' => 'required|string|max:255',
        'gender' => 'required|string|max:255',
        'date_of_joining' => 'required|date',
        'contact' => 'required|string|max:15',
        'email_id' => 'required|email|unique:employees,email_id',
        'password' => 'required|string|min:8',
        'department_id' => 'required|exists:departments,id',
        'role_id' => 'required|exists:roles,id',
        'jobtype' => 'required|string',
    ]);

    $employee = Employee::create([
        'full_name' => $request->full_name,
        'gender' => $request->gender,
        'date_of_joining' => $request->date_of_joining,
        'contact' => $request->contact,
        'email_id' => $request->email_id,
        'password' => bcrypt($request->password),
        'department_id' => $request->department_id,
        'role_id' => $request->role_id,
        'jobtype' => $request->jobtype,
    ]);

    // Load related department and role
    $employee->load('department', 'role');

    return response()->json([
        'success' => true,
        'message' => 'Employee added successfully!',
        'employee' => $employee,
        // Pass the redirect URL
    ]);
}
public function employeeList()
{
    $employees = Employee::with('department', 'role')->get();
    $departments = Department::all(); // Fetch all departments
    $roles = Role::all(); // Fetch all roles

    return view('admin.employee', compact('employees', 'departments', 'roles'));
}

public function checkEmail(Request $request)
{
    $exists = Employee::where('email_id', $request->email_id)->exists();

    return response()->json(['exists' => $exists]);
}



    public function getRolesByDepartment($departmentId)
    {
        // Fetch roles based on the department ID
        $roles = Role::where('department_id', $departmentId)->get();

     return response()->json(['roles' => $roles]);
    }
public function getEmployeesByRole(Request $request)
{
    $roleId = $request->query('role_id');
    $employees = Employee::where('role_id', $roleId)->get();
    
    return response()->json($employees);
}

public function destroy($id)
{
    $employee = Employee::find($id);
    if ($employee) {
        $employee->delete();
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false, 'message' => 'Employee not found']);
    }
}
 public function profile()
    {
        // Check if the employee is logged in
        if (!Auth::guard('employee')->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Get the logged-in employee
        $employee = Auth::guard('employee')->user();

        // Load the profile view and pass employee data
        return view('employee.profile', compact('employee'));
    }
public function myTasks()
{
    $futureTasks = Task::where('employee_id', auth()->id())
                       ->where('deadline', '>=', now()) // Future tasks
                       ->orderBy('deadline', 'asc')
                       ->get();

    $pastTasks = Task::where('employee_id', auth()->id())
                     ->where('deadline', '<', now()) // Past tasks
                     ->orderBy('deadline', 'desc')
                     ->get();

    return view('employee.tasks', compact('futureTasks', 'pastTasks'));
}

public function dashboard()
{
    // Check if the employee is authenticated
    if (!Auth::guard('employee')->check()) {
        return redirect()->route('employee.login')->with('error', 'Please log in to view your dashboard.');
    }

    // Get the logged-in employee
    $employee = Auth::guard('employee')->user();

    // Fetch task counts based on assigned_to field
    return view('employee.dashboard', [
        'totalTasks' => Task::where('assigned_to', $employee->id)->count(),
        'pendingTasks' => Task::where('assigned_to', $employee->id)->where('status', 'pending')->count(),
        'startedTasks' => Task::where('assigned_to', $employee->id)->where('status', 'started')->count(),
        'completedTasks' => Task::where('assigned_to', $employee->id)->where('status', 'completed')->count(),
        'reviewTasks' => Task::where('assigned_to', $employee->id)->where('status', 'review')->count(),
    ]);
}



// //filter
public function filterEmployees(Request $request)
{
    $query = Employee::query();

    if ($request->has('email') && $request->email) {
        $query->where('email_id', 'like', '%' . $request->email . '%');
    }

    if ($request->has('department_id') && $request->department_id) {
        $query->where('department_id', $request->department_id);
    }

    if ($request->has('role_id') && $request->role_id) {
        $query->where('role_id', $request->role_id);
    }

    $employees = $query->with(['department', 'role'])->get();

    return response()->json(['employees' => $employees]);
}



}






