<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departments & Roles</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

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
<form id="addEmployeeForm" method="POST" action="{{ route('admin.addEmployee') }}"  class="bg-gray-800 p-6 rounded-lg shadow-lg">
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
            <input type="password" name="password" class="w-full p-2 rounded bg-gray-700 text-white" required>
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
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
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

    <button type="submit" class="w-full md:w-auto mt-4 px-6 py-2 bg-[#ff0003] hover:bg-red-700 text-white rounded">SUBMIT</button>
</form>

<!-- Success Message -->
<!-- Success message that will show after employee is added -->
<div id="successMessage" class="hidden text-green-600"></div>



    <hr class="my-6 border-gray-600">

    <!-- Employee Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border border-gray-600 text-sm md:text-base" id="employeeList">
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
    <button onclick="deleteEmployee(event, {{ $employee->id }})" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
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
$(document).ready(function () {
    // Handle form submission
    $('#addEmployeeForm').on('submit', function (e) {
        e.preventDefault();

        // Email validation
        var email = $('input[name="email_id"]').val();
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailPattern.test(email)) {
            alert('Please enter a valid email address');
            return; // Stop form submission if email is invalid
        }

        var formData = $(this).serialize();  // Collect form data
$.ajax({
    url: "{{ route('admin.addEmployee') }}",
    type: 'POST',
    data: formData,
    success: function (response) {
           console.log(response);
        if (response.success) {
            // Display success message
            $('#successMessage').removeClass('hidden').text(response.message);

            // Reset the form
            $('#addEmployeeForm')[0].reset();

            // Add the new employee to the table dynamically
            var newEmployee = response.employee;
            
            var newRow = `
                <tr class="bg-gray-700 hover:bg-gray-600">
                    <td class="p-3 border">${newEmployee.id}</td>
                    <td class="p-3 border">${newEmployee.full_name}</td>
                    <td class="p-3 border">${newEmployee.gender}</td>
                    <td class="p-3 border">${newEmployee.date_of_joining}</td>
                    <td class="p-3 border">${newEmployee.contact}</td>
                    <td class="p-3 border">${newEmployee.email_id}</td>
                    <td class="p-3 border">${newEmployee.department.name}</td>
                    <td class="p-3 border">${newEmployee.role.name}</td>
                    <td class="p-3 border">${newEmployee.jobtype}</td>
                    <td class="p-3 border text-center">
                        <button onclick="deleteEmployee(event, ${newEmployee.id})" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Delete
                        </button>
                    </td>
                </tr>
            `;

            // Prepend new row to the employee list table
            $('#employeeList tbody').prepend(newRow);
        } else {
            alert(response.message || 'Error adding employee');
        }
    },
    error: function (xhr, status, error) {
        $('#errorMessage').removeClass('hidden').text('An error occurred: ' + error);
        setTimeout(function() {
            $('#errorMessage').addClass('hidden');
        }, 5000);
    }
});

    });
});


$(document).ready(function() {
    // Handle department change
    $('#departmentSelect').on('change', function() {
        var departmentId = $(this).val();
        if (departmentId) {
            $.ajax({
                url: "/admin/employees/roles/" + departmentId,
                method: "GET",
                success: function(response) {
                    var roleSelect = $('#roleSelect');
                    roleSelect.empty(); // Clear existing options
                    roleSelect.append('<option value="">Select Role</option>'); // Add default option
                    response.roles.forEach(function(role) {
                        roleSelect.append('<option value="' + role.id + '">' + role.name + '</option>');
                    });
                }
            });
        }
    });
});

function deleteEmployee(event, employeeId) {
    event.preventDefault(); // Prevent page reload

    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    if (confirm("Are you sure you want to delete this employee?")) {
        fetch(`/admin/employees/${employeeId}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data); // Check the response
            if (data.success) {
                alert("Employee deleted successfully!");
                event.target.closest("tr").remove(); // Remove the row from the table
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => console.error("Error:", error));
    }
}


</script>
