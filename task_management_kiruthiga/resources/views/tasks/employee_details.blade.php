<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details | Task Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-black min-h-screen">
    <h2 class="text-3xl font-bold mb-6 text-center text-white">Employee Details</h2>

 <!-- Employee Detail Form -->
<form id="employeeDetailForm" method="POST" action="{{ route('employee_details.store') }}" class="bg-gray-800 p-6 rounded-lg shadow-md space-y-4">
    @csrf

    <!-- Personal Info -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm text-white">Full Name</label>
            <input type="text" name="fullname" class="w-full px-3 py-2 border border-gray-700 bg-gray-900 rounded-lg text-white focus:ring-2 focus:ring-red-500" required>
        </div>
        <div>
            <label class="block text-sm text-white">Gender</label>
            <select name="gender" class="w-full px-3 py-2 border border-gray-700 bg-gray-900 rounded-lg text-white focus:ring-2 focus:ring-red-500" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>
    </div>

    <!-- Contact Details -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm text-white">Date of Joining</label>
            <input type="date" name="date_of_joining" class="w-full px-3 py-2 border border-gray-700 bg-gray-900 rounded-lg text-white focus:ring-2 focus:ring-red-500" required>
        </div>
        <div>
            <label class="block text-sm text-white">Contact</label>
            <input type="text" name="contact" class="w-full px-3 py-2 border border-gray-700 bg-gray-900 rounded-lg text-white focus:ring-2 focus:ring-red-500" required>
        </div>
    </div>

    <!-- Login Details -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm text-white">Email</label>
            <input type="email" name="email" class="w-full px-3 py-2 border border-gray-700 bg-gray-900 rounded-lg text-white focus:ring-2 focus:ring-red-500" required>
        </div>
       <div class="relative">
    <label class="block text-sm text-white">Password</label>
    <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-700 bg-gray-900 rounded-lg text-white focus:ring-2 focus:ring-red-500 pr-10" required>
    
    <!-- Eye Icon -->
    <span class="absolute right-3 top-9 cursor-pointer text-gray-400 hover:text-white" onclick="togglePassword()">
        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>
        </svg>
    </span>
</div>
    </div>

    <!-- Work Details -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm text-white">Department</label>
            <select name="department" class="w-full px-3 py-2 border border-gray-700 bg-gray-900 rounded-lg text-white focus:ring-2 focus:ring-red-500" required>
                <option value="">Select Department</option>
                @foreach($roleDetails as $role)
                    <option value="{{ $role->department }}">{{ $role->department }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-white">Designation</label>
            <select name="designation" class="w-full px-3 py-2 border border-gray-700 bg-gray-900 rounded-lg text-white focus:ring-2 focus:ring-red-500" required>
                <option value="">Select Designation</option>
                @foreach($roleDetails as $role)
                    <option value="{{ $role->role }}">{{ $role->role }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Job Type & Role -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm text-white">Job Type</label>
            <select name="jobtype" class="w-full px-3 py-2 border border-gray-700 bg-gray-900 rounded-lg text-white focus:ring-2 focus:ring-red-500" required>
                <option value="onsite">Onsite</option>
                <option value="remote">Remote</option>
            </select>
        </div>
        <div>
            <label class="block text-sm text-white">Role</label>
            <select name="role_id" class="w-full px-3 py-2 border border-gray-700 bg-gray-900 rounded-lg text-white focus:ring-2 focus:ring-red-500" required>
                <option value="">Select Role</option>
                @foreach($roleDetails as $role)
                    <option value="{{ $role->id }}">{{ $role->id }}</option>
                @endforeach
            </select>
        </div>
    </div>

  <!-- Centered Submit Button -->
<div class="flex justify-center mt-4">
    <button type="submit" class="flex items-center gap-2 bg-[#ff0003] text-white px-6 py-2 rounded-md hover:bg-red-600 hover:shadow-lg hover:shadow-red-500/50 transition duration-300">
        <!-- Employee SVG Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
            <path d="M12 2a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 12c4.418 0 8 1.79 8 4v2H4v-2c0-2.21 3.582-4 8-4Z"/>
        </svg>
        Add Employee
    </button>
</div>

</form>



    <!-- Employee Table -->
    <div class="overflow-x-auto mt-6">
        <table class="min-w-full table-auto border-collapse bg-black-800 rounded-lg shadow-md">
            <thead>
                <tr class="text-white bg-[#ff0003]">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Full Name</th>
                    <th class="border px-4 py-2">Gender</th>
                    <th class="border px-4 py-2">Date of Joining</th>
                    <th class="border px-4 py-2">Contact</th>
                    <th class="border px-4 py-2">Email_id</th>
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
                   <td class="border px-4 py-2">
    {{ optional($employee->role)->role ?? 'N/A' }} - {{ optional($employee->role)->department ?? 'N/A' }}
</td>

                    <td class="border px-4 py-2">

                       <button onclick="deleteEmployee({{ $employee->id }})" 
    class="flex items-center gap-2 bg-[#ff0003] text-white px-4 py-1 rounded-md hover:bg-red-600 hover:shadow-lg hover:shadow-red-500/50 transition duration-300">
    
    <!-- Trash SVG Icon -->
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
    </svg>

    Delete
</button>

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
//for eye toggle 
 function togglePassword() {
    const passwordField = document.getElementById("password");
    const eyeIcon = document.getElementById("eyeIcon");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M13.875 18.825A10.045 10.045 0 012 12s3.5-7 10-7 10 7 10 7a9.978 9.978 0 01-2.125 3.825M9.75 15.75a3 3 0 114.5-4.5"/>`;
    } else {
        passwordField.type = "password";
        eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>`;
    }
}
 $(document).ready(function() {
        $('#employeeDetailForm').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

          

            $.ajax({
                 url: $(this).attr('action'),     // Get the form action URL
                type: 'POST',
                 dataType: 'json',
                  data: $(this).serialize(),
               success: function(response) {
    alert(response.message); // Show success message

 // Extract role details safely
                let roleDetails = response.employee.role 
                    ? response.employee.role.role + ' - ' + response.employee.role.department 
                    : 'N/A';

     // Append new employee data to the table dynamically
                $('#employeeTableBody').append(`
                    <tr id="employee_${response.employee.id}" class="text-white hover:bg-black-700 transition duration-300">
                        <td class="border px-4 py-2">${response.employee.id}</td>
                        <td class="border px-4 py-2">${response.employee.fullname}</td>
                        <td class="border px-4 py-2">${response.employee.gender}</td>
                        <td class="border px-4 py-2">${response.employee.date_of_joining}</td>
                        <td class="border px-4 py-2">${response.employee.contact}</td>
                        <td class="border px-4 py-2">${response.employee.email}</td>
                        <td class="border px-4 py-2">${response.employee.department}</td>
                        <td class="border px-4 py-2">${response.employee.designation}</td>
                        <td class="border px-4 py-2">${response.employee.jobtype}</td>
                        <td class="border px-4 py-2">${roleDetails}</td>
                        <td class="border px-4 py-2">
                            <button onclick="deleteEmployee(${response.employee.id})" 
                                class="flex items-center gap-2 bg-red-500 text-white px-4 py-1 rounded-md hover:bg-red-600 hover:shadow-lg hover:shadow-red-500/50 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Delete
                            </button>
                        </td>
                    </tr>
                `);



    // Optionally, update the UI without reloading
    $('#employeeDetailForm')[0].reset(); // Reset form fields
    // Append the new employee to the list dynamically (if applicable)
},
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });
    });
</script>
</html>  