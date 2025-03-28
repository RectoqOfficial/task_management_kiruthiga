<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details | Task Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-gray-900 min-h-screen">
    <h2 class="text-3xl font-bold mb-6 text-center text-white">Employee Details</h2>

    <!-- Employee Detail Form -->
<!-- Employee Detail Form -->
<form id="employeeDetailForm" method="POST" action="{{ route('employee_details.store') }}" class="mb-6 bg-gray-800 p-6 rounded-lg shadow-md">
    @csrf
    <div class="space-y-4">
        <div>
            <label for="fullname" class="block text-sm text-white">Full Name</label>
            <input type="text" id="fullname" name="fullname" class="w-full px-4 py-2 border border-gray-700 rounded-lg bg-gray-900 text-white focus:ring-2 focus:ring-purple-500" required>
        </div>

        <div>
            <label for="gender" class="block text-sm text-white">Gender</label>
            <select id="gender" name="gender" class="w-full px-4 py-2 border border-gray-700 rounded-lg bg-gray-900 text-white focus:ring-2 focus:ring-purple-500" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div>
            <label for="date_of_joining" class="block text-sm text-white">Date of Joining</label>
            <input type="date" id="date_of_joining" name="date_of_joining" class="w-full px-4 py-2 border border-gray-700 rounded-lg bg-gray-900 text-white focus:ring-2 focus:ring-purple-500" required>
        </div>

        <div>
            <label for="contact" class="block text-sm text-white">Contact</label>
            <input type="text" id="contact" name="contact" class="w-full px-4 py-2 border border-gray-700 rounded-lg bg-gray-900 text-white focus:ring-2 focus:ring-purple-500" required>
        </div>

        <div>
            <label for="email" class="block text-sm text-white">Email</label>
            <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-700 rounded-lg bg-gray-900 text-white focus:ring-2 focus:ring-purple-500" required>
        </div>
<div>
    <label for="password" class="block text-sm text-white">Password</label>
    <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-700 rounded-lg bg-gray-900 text-white focus:ring-2 focus:ring-purple-500" required>
</div>

        <div>
            <label for="department" class="block text-sm text-white">Department</label>
            <select name="department" class="w-full p-3 border border-gray-700 bg-gray-800 rounded-lg focus:ring-2 focus:ring-purple-500 text-white" required>
                    <option value="">Select Department</option>
                    @foreach($roleDetails as $role)
                        <option value="{{ $role->department }}">{{ $role->department }}</option>
                    @endforeach
                </select>
        </div>
  <div>
                <label class="block font-semibold text-gray-300">Designation</label>
                <select name="designation" class="w-full p-3 border border-gray-700 bg-gray-800 rounded-lg focus:ring-2 focus:ring-purple-500 text-white" required>
                    <option value="">Select Designation</option>
                    @foreach($roleDetails as $role)
                        <option value="{{ $role->role }}">{{ $role->role }}</option>
                    @endforeach
                </select>
            </div>
        <div>
            <label for="jobtype" class="block text-sm text-white">Job Type</label>
            <select id="jobtype" name="jobtype" class="w-full px-4 py-2 border border-gray-700 rounded-lg bg-gray-900 text-white focus:ring-2 focus:ring-purple-500" required>
                <option value="onsite">Onsite</option>
                <option value="remote">Remote</option>
            </select>
        </div>
 <div>
                <label class="block font-semibold text-gray-300">Role</label>
                <select name="role_id" class="w-full p-3 border border-gray-700 bg-gray-800 rounded-lg focus:ring-2 focus:ring-purple-500 text-white" required>
                    <option value="">Select Role</option>
                    @foreach($roleDetails as $role)
                        <option value="{{ $role->id }}">{{ $role->role }}</option>
                    @endforeach
                </select>
            </div>

        <button type="submit" class="bg-violet-500 text-white px-6 py-2 rounded-md hover:bg-violet-600 transition duration-300">Add Employee</button>
    </div>
</form>


    <!-- Employee Table -->
    <div class="overflow-x-auto mt-6">
        <table class="min-w-full table-auto border-collapse bg-gray-800 rounded-lg shadow-md">
            <thead>
                <tr class="text-white">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Full Name</th>
                    <th class="border px-4 py-2">Gender</th>
                    <th class="border px-4 py-2">Date of Joining</th>
                    <th class="border px-4 py-2">Contact</th>
                    <th class="border px-4 py-2">Email</th>
                    <th class="border px-4 py-2">Department</th>
                    <th class="border px-4 py-2">Designation</th>
                    <th class="border px-4 py-2">Job Type</th>
                    <th class="border px-4 py-2">Role</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody id="employeeTableBody">
                @foreach($employees as $employee)
                <tr id="employee_{{ $employee->id }}" class="text-white hover:bg-gray-700 transition duration-300">
                    <td class="border px-4 py-2">{{ $employee->id }}</td>
                    <td class="border px-4 py-2">{{ $employee->fullname }}</td>
                    <td class="border px-4 py-2">{{ $employee->gender }}</td>
                    <td class="border px-4 py-2">{{ $employee->date_of_joining }}</td>
                    <td class="border px-4 py-2">{{ $employee->contact }}</td>
                    <td class="border px-4 py-2">{{ $employee->email }}</td>
                    <td class="border px-4 py-2">{{ $employee->department }}</td>
                    <td class="border px-4 py-2">{{ $employee->designation }}</td>
                    <td class="border px-4 py-2">{{ $employee->jobtype }}</td>
                    <td class="border px-4 py-2">{{ $employee->role->role }} - {{ $employee->role->department }}</td>
                    <td class="border px-4 py-2">
                        <button onclick="editEmployee({{ $employee->id }})" class="bg-yellow-500 text-white px-4 py-1 rounded-md hover:bg-yellow-600 transition duration-300">Edit</button>
                        <button onclick="deleteEmployee({{ $employee->id }})" class="bg-red-500 text-white px-4 py-1 rounded-md hover:bg-red-600 transition duration-300">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

<script>
 function deleteEmployee(id) {
    fetch(`/employee-details/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json' // if you are sending JSON data
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`employee_${id}`).remove();
        }
    })
    .catch(error => console.log(error));
}


</script>
</html>
