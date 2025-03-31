<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departments & Roles</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-black text-white min-h-screen">

    <h2 class="text-2xl font-bold mb-4">Employee Details</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-500 text-white p-2 mb-4 rounded">{{ session('success') }}</div>
    @endif

    <!-- Employee Form -->
    <form action="{{ route('employees.store') }}" method="POST" class="bg-gray-800 p-6 rounded-lg shadow-lg">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block">Full Name</label>
                <input type="text" name="full_name" class="w-full p-2 rounded bg-gray-700 text-white" required>
            </div>
            <div>
                <label class="block">Gender</label>
                <select name="gender" class="w-full p-2 rounded bg-gray-700 text-white" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div>
                <label class="block">Date of Joining</label>
                <input type="date" name="date_of_joining" class="w-full p-2 rounded bg-gray-700 text-white" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div>
                <label class="block">Contact</label>
                <input type="text" name="contact" class="w-full p-2 rounded bg-gray-700 text-white" required>
            </div>
            <div>
                <label class="block">Email ID</label>
                <input type="email" name="email_id" class="w-full p-2 rounded bg-gray-700 text-white" required>
            </div>
            <div>
                <label class="block">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" class="w-full p-2 rounded bg-gray-700 text-white pr-10" required>
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div>
                <label class="block">Department</label>
                <select name="department_id" id="departmentSelect" class="w-full p-2 rounded bg-gray-700 text-white" required>
                    <option value="">Select Department</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block">Role</label>
                <select name="role_id" id="roleSelect" class="w-full p-2 rounded bg-gray-700 text-white" required>
                    <option value="">Select Role</option>
                </select>
            </div>
            <div>
                <label class="block">Job Type</label>
                <select name="jobtype" class="w-full p-2 rounded bg-gray-700 text-white" required>
                    <option value="Full-Time">Full-Time</option>
                    <option value="Part-Time">Part-Time</option>
                    <option value="Contract">Contract</option>
                </select>
            </div>
        </div>

        <button type="submit" class="w-full md:w-auto mt-4 px-6 py-2 bg-[#ff0003] hover:bg-red-700 text-white rounded">Add Employee</button>
    </form>

    <hr class="my-6 border-gray-600">

    <!-- Employee Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border border-gray-600 text-sm md:text-base">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="p-3 border">ID</th>
                    <th class="p-3 border">Full Name</th>
                    <th class="p-3 border">Gender</th>
                    <th class="p-3 border">Date of Joining</th>
                    <th class="p-3 border">Contact</th>
                    <th class="p-3 border">Email ID</th>
                    <th class="p-3 border">Department</th>
                    <th class="p-3 border">Role</th>
                    <th class="p-3 border">Job Type</th>
                    <th class="p-3 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    <tr class="bg-gray-700 hover:bg-gray-600">
                        <td class="p-3 border">{{ $employee->id }}</td>
                        <td class="p-3 border">{{ $employee->full_name }}</td>
                        <td class="p-3 border">{{ $employee->gender }}</td>
                        <td class="p-3 border">{{ $employee->date_of_joining }}</td>
                        <td class="p-3 border">{{ $employee->contact }}</td>
                        <td class="p-3 border">{{ $employee->email_id }}</td>
                        <td class="p-3 border">{{ $employee->department->name }}</td>
                        <td class="p-3 border">{{ $employee->role->name }}</td>
                        <td class="p-3 border">{{ $employee->jobtype }}</td>
                        <td class="p-3 border text-center">
                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


<script>
    document.getElementById('departmentSelect').addEventListener('change', function () {
        var departmentId = this.value;
        var roleSelect = document.getElementById('roleSelect');
        
        // Clear existing options
        roleSelect.innerHTML = '<option value="">Select Role</option>';
        
        if (departmentId) {
            fetch(`/get-roles/${departmentId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(role => {
                        var option = document.createElement('option');
                        option.value = role.id;
                        option.textContent = role.name;
                        roleSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching roles:', error));
        }
    });
      document.getElementById('togglePassword').addEventListener('click', function () {
        var passwordInput = document.getElementById('password');
        var eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7A10.05 10.05 0 0112 5c2.044 0 3.937.617 5.521 1.675"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />';
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />';
        }
    });
</script>
