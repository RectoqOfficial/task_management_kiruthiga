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
    <style>
        /* Custom scrollbar styles */
        .max-w-5xl::-webkit-scrollbar {
            width: 6px;
        }
        .max-w-5xl::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
        }
        .max-w-5xl::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }
        /* Responsive table styles */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            word-wrap: break-word;
            white-space: normal;
        }
    </style>
</head>
@extends('layouts.app')

@section('content')
@if(session('success'))
    <script>
        alert("✅ {{ session('success') }}");
    </script>
@endif

<div class="container mx-auto p-6 bg-black text-white min-h-screen">

    <h2 class="text-2xl font-bold mb-4 max-w-5xl mx-auto text-center">Employee Details</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-500 text-white p-2 mb-4 rounded text-center">{{ session('success') }}</div>
    @endif

    <!-- Employee Form -->
    <form id="addEmployeeForm" method="POST" action="{{ route('admin.addEmployee') }}" class="max-w-5xl mx-auto">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block">Full Name</label>
                <input type="text" name="full_name" class="w-full p-2 rounded bg-gray-700 text-white border border-transparent focus:outline-none focus:ring-2 focus:ring-[#ff0003]" required>
            </div>
            <div>
                <label class="block">Gender</label>
                <select name="gender" class="w-full p-2 rounded bg-gray-700 text-white border border-transparent focus:outline-none focus:ring-2 focus:ring-[#ff0003]" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div>
                <label class="block">Date of Joining</label>
                <input type="date" name="date_of_joining" class="w-full p-2 rounded bg-gray-700 text-white border border-transparent focus:outline-none focus:ring-2 focus:ring-[#ff0003]" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div>
                <label class="block">Contact</label>
                <input type="text" name="contact" class="w-full p-2 rounded bg-gray-700 text-white border border-transparent focus:outline-none focus:ring-2 focus:ring-[#ff0003]" required>
            </div>
            <div>
                <label class="block">Email ID</label>
                <input type="email" name="email_id" class="w-full p-2 rounded bg-gray-700 text-white border border-transparent focus:outline-none focus:ring-2 focus:ring-[#ff0003]" required>
            </div>
            <div>
                <label class="block">Password</label>
                <input type="password" name="password" class="w-full p-2 rounded bg-gray-700 text-white border border-transparent focus:outline-none focus:ring-2 focus:ring-[#ff0003]" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div>
                <label class="block">Department</label>
                <select name="department_id" id="departmentSelect" class="w-full p-2 rounded bg-gray-700 text-white border border-transparent focus:outline-none focus:ring-2 focus:ring-[#ff0003]" required>
                    <option value="">Select Department</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block">Role</label>
                <select name="role_id" id="roleSelect" class="w-full p-2 rounded bg-gray-700 text-white border border-transparent focus:outline-none focus:ring-2 focus:ring-[#ff0003]" required>
                    <option value="">Select Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block">Job Type</label>
                <select name="jobtype" class="w-full p-2 rounded bg-gray-700 text-white border border-transparent focus:outline-none focus:ring-2 focus:ring-[#ff0003]" required>
                    <option value="Full-Time">Full-Time</option>
                    <option value="Part-Time">Part-Time</option>
                    <option value="Contract">Contract</option>
                </select>
            </div>
        </div>

        <div class="flex justify-center mt-4">
            <button type="submit" class="px-6 py-2 bg-[#ff0003] hover:bg-red-700 text-white rounded">SUBMIT</button>
        </div>
    </form>

    <hr class="my-6 border-gray-600">
    
    <h2 class="text-2xl font-bold mb-4 max-w-5xl mx-auto text-center">Table Details</h2>
 <div class="flex flex-wrap gap-6 p-7 text-white max-w-5xl mx-auto">
    <!-- Email Search -->
    <div class="w-full md:w-auto">
        <input type="text" id="searchEmail" placeholder="Search by Email"
               class="w-full p-2 text-black border border-white rounded bg-white">
    </div>

    <!-- Department Filter -->
    <div class="w-full md:w-auto">
        <select id="filterDepartment"
                class="w-full p-2 text-black border border-white rounded bg-white">
            <option value="">Filter by Department</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Role Filter -->
    <div class="w-full md:w-auto">
        <select id="filterRole"
                class="w-full p-2 text-black border border-white rounded bg-white">
            <option value="">Filter by Role</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Search Button -->
    <div class="w-full md:w-auto">
        <button onclick="filterEmployees()"
                class="w-full px-4 py-2 bg-[#ff0003] hover:bg-red-700 text-white rounded border border-white">
            Search
        </button>
    </div>
</div>


    <!-- Employee Table -->
    <div class="max-w-5xl mx-auto overflow-x-auto" style="max-height: 500px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 #444;">
        <table class="w-full text-left bg-[#ff0003] text-sm md:text-base" id="employeeList">
            <thead class="bg-[#ff0003] text-white text-sm font-semibold text-center">
                <tr>
                    <th class="p-4 min-w-[80px] max-w-[100px] truncate">ID</th>
                    <th class="p-4 min-w-[160px] max-w-[180px] truncate">Full Name</th>
                    <th class="p-4 min-w-[100px] max-w-[120px] truncate">Gender</th>
                    <th class="p-4 min-w-[120px] max-w-[140px] truncate">D.O.J</th>
                    <th class="p-4 min-w-[140px] max-w-[160px] truncate">Contact</th>
                    <th class="p-4 min-w-[180px] max-w-[220px] truncate">Email ID</th>
                    <th class="p-4 min-w-[140px] max-w-[160px] truncate">Department</th>
                    <th class="p-4 min-w-[100px] max-w-[120px] truncate">Role</th>
                    <th class="p-4 min-w-[120px] max-w-[140px] truncate">Job Type</th>
                    <th class="p-4 min-w-[100px] max-w-[120px] truncate">Actions</th>
                </tr>
            </thead>
            <tbody class="overflow-y-auto thin-scrollbar">
                @foreach($employees as $employee)
                    <tr class="bg-gray-700 hover:bg-gray-600">
                        <td class="p-3">{{ $employee->id }}</td>
                        <td class="p-3">{{ $employee->full_name }}</td>
                        <td class="p-3">{{ $employee->gender }}</td>
                        <td class="p-3">{{ $employee->date_of_joining }}</td>
                        <td class="p-3">{{ $employee->contact }}</td>
                        <td class="p-3">{{ $employee->email_id }}</td>
                        <td class="p-3">{{ $employee->department->name }}</td>
                        <td class="p-3">{{ $employee->role->name }}</td>
                        <td class="p-3">{{ $employee->jobtype }}</td>
                        <td class="p-3 text-center">
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

$('#addEmployeeForm').on('submit', function (e) {
    e.preventDefault();

    var email = $('input[name="email_id"]').val();
    var password = $('input[name="password"]').val();

    // ✅ Email pattern check
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailPattern.test(email)) {
        alert('❌ Please enter a valid email address');
        return;
    }

    // ✅ Password length & pattern check (at least 1 letter and 1 number)
    var passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    if (!passwordPattern.test(password)) {
        alert('❌ Password must be at least 8 characters long and contain both letters and numbers');
        return;
    }
 window.API_BASE_URL = "{{ env('MIX_API_URL') }}";
   console.log("API Base URL:", API_BASE_URL);
let $api_url = window.API_BASE_URL + "/admin/check-email";
    // ✅ Check if email already exists via AJAX
    $.ajax({
        url: $api_url,
        type: "POST",
        data: {
            email_id: email,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.exists) {
                alert("❌ Email already exists. Please enter a different email.");
            } else {
                // Proceed with form submission
                var formData = $('#addEmployeeForm').serialize();
 window.API_BASE_URL = "{{ env('MIX_API_URL') }}";
   console.log("API Base URL:", API_BASE_URL);
let $api_url = window.API_BASE_URL + "/admin/employees/add";

                $.ajax({
                    url: $api_url,
                    type: 'POST',
                    data: formData + "&_token=" + $('meta[name="csrf-token"]').attr('content'),
                    success: function (response) {
                        if (response.success) {
                            alert('✅ Employee added successfully!');
                            $('#addEmployeeForm')[0].reset();

                            var newEmployee = response.employee;
                            var newRow = `
                                <tr class="bg-gray-700 hover:bg-gray-600">
                                    <td class="p-3 ">${newEmployee.id}</td>
                                    <td class="p-3 ">${newEmployee.full_name}</td>
                                    <td class="p-3 ">${newEmployee.gender}</td>
                                    <td class="p-3 ">${newEmployee.date_of_joining}</td>
                                    <td class="p-3 ">${newEmployee.contact}</td>
                                    <td class="p-3 ">${newEmployee.email_id}</td>
                                    <td class="p-3 ">${newEmployee.department.name}</td>
                                    <td class="p-3 ">${newEmployee.role.name}</td>
                                    <td class="p-3">${newEmployee.jobtype}</td>
                                    <td class="p-3 text-center">
                                        <button onclick="deleteEmployee(event, ${newEmployee.id})" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            `;
                            $('#employeeList tbody').append(newRow);
                        } else {
                            alert(response.message || '❌ Error adding employee');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        alert("❌ Error: " + xhr.responseText);
                    }
                });
            }
        },
        error: function () {
            alert("❌ Error checking email");
        }
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

// ///filter
// ///filter
   function filterEmployees() {
        let email = document.getElementById('searchEmail').value;
        let departmentId = document.getElementById('filterDepartment').value;
        let roleId = document.getElementById('filterRole').value;
fetch(`/employees/filter?email=${email}&department_id=${departmentId}&role_id=${roleId}`)

            .then(response => response.json())
            .then(data => {
                let tbody = document.querySelector("#employeeList tbody");
                tbody.innerHTML = "";

                data.employees.forEach(employee => {
                    tbody.innerHTML += `
                        <tr class="bg-gray-700 hover:bg-gray-600">
                            <td class="p-3 ">${employee.id}</td>
                            <td class="p-3 ">${employee.full_name}</td>
                            <td class="p-3 ">${employee.gender}</td>
                            <td class="p-3 ">${employee.date_of_joining}</td>
                            <td class="p-3 ">${employee.contact}</td>
                            <td class="p-3 ">${employee.email_id}</td>
                            <td class="p-3 ">${employee.department.name}</td>
                            <td class="p-3 ">${employee.role.name}</td>
                            <td class="p-3 ">${employee.jobtype}</td>
                            <td class="p-3  text-center">
                                <button onclick="deleteEmployee(event, ${employee.id})" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    `;
                });
            });
    }
        // Toggle password visibility
 function togglePassword() {
    const passwordField = document.getElementById("password");
    const eyeIcon = document.getElementById("eyeIcon");

    if (passwordField.type === "password") {
        passwordField.type = "text"; // Show Password
        eyeIcon.innerHTML = `<path d="M288 144c-79.5..."></path>`; // Open Eye
    } else {
        passwordField.type = "password"; // Hide Password
        eyeIcon.innerHTML = `<path d="M572.52 246.6c..."></path>`; // Closed Eye
    }
}

</script>
