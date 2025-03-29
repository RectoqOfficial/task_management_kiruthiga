
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Task Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
@extends('layouts.app')

@section('content')
{{-- <pre>{{ print_r($roleDetails->toArray(), true) }}</pre> --}}

<div class="container mx-auto p-6 bg-gray-900 text-white min-h-screen">
    <h2 class="text-2xl font-bold mb-4 text-center">Task Details</h2>

    <!-- Task Form -->
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
<form id="taskForm" action="{{ route('tasks.store') }}" method="POST">
    @csrf
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-300">Task Title</label>
            <input type="text" name="task_title" id="taskTitle" class="w-full px-4 py-2 border border-gray-600 rounded-lg" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300">Description</label>
            <input type="text" name="description" id="description" class="w-full px-4 py-2 border border-gray-600 rounded-lg" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300">Department</label>
            <select  id="department" class="w-full px-3 py-2 border border-gray-700 bg-gray-900 rounded-lg" required>
                <option disabled selected>Select Department</option>
                @foreach($departments as $department)
                    <option value="{{ $department }}">{{ $department }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300">Role</label>
            <select  id="role" class="w-full px-3 py-2 border border-gray-700 bg-gray-900 rounded-lg" required>
                <option disabled selected>Select Role</option>
                {{-- @foreach($roles as $role)
                    <option value="{{ $role }}">{{ $role }}</option>
                @endforeach --}}
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300">Assigned To</label>
            <select name="assigned_to" id="assigned_to" class="w-full px-3 py-2 border border-gray-700 bg-gray-900 rounded-lg" required>
                <option selected disabled>Select Employee</option>
                {{-- @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->fullname }} ({{ $employee->email }})</option>
                @endforeach --}}
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300">No. of Days</label>
            <input type="number" name="no_of_days" id="noOfDays" class="w-full px-4 py-2 border border-gray-600 rounded-lg" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300">Task Create Date</label>
            <input type="date" name="task_create_date" id="taskCreateDate" class="w-full px-4 py-2 border border-gray-600 rounded-lg" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300">Task Start Date</label>
            <input type="date" name="task_start_date" id="taskStartDate" class="w-full px-4 py-2 border border-gray-600 rounded-lg" required onchange="calculateDeadline()">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300">Deadline</label>
            <input type="text" name="deadline" id="deadline" class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 cursor-not-allowed" readonly>
        </div>
    </div>

    <button type="submit" id="addTaskBtn" class="mt-4 px-6 py-2 bg-violet-300 text-white rounded-lg">Add Task</button>
</form>

    </div>

    <!-- Task Table with Horizontal Scroll -->
    <div class="mt-6 bg-gray-800 p-6 rounded-lg shadow-lg overflow-x-auto">
        <h3 class="text-xl font-semibold mb-3">Task List</h3>
        <table class="w-full border-collapse border border-gray-600 table-auto">
            <thead>
                <tr class="bg-purple-700/60 tesxt-white">
                    <th class="border px-4 py-2 text-sm">ID</th>
                    <th class="border px-4 py-2 text-sm">Task Title</th>
                    <th class="border px-4 py-2 text-sm">Assigned To</th>
                    <th class="border px-4 py-2 text-sm">Status</th>
                    <th class="border px-4 py-2 text-sm">Description</th>
                    <th class="border px-4 py-2 text-sm">Task Start Date</th>
                    <th class="border px-4 py-2 text-sm">Task Create Date</th>
                    <th class="border px-4 py-2 text-sm">No. of Days</th>
                    <th class="border px-4 py-2 text-sm">Remarks</th>
                    <th class="border px-4 py-2 text-sm">Actions</th>
                </tr>
            </thead>
            <tbody id="taskTableBody"></tbody>
        </table>
    </div>
</div>

{{-- <script>
    let taskId = 1;

 function calculateDeadline() {
    let startDate = document.getElementById("taskStartDate").value;
    let days = document.getElementById("noOfDays").value;

    if (startDate && days) {
        let deadline = new Date(startDate);
        deadline.setDate(deadline.getDate() + parseInt(days)-1); // Add days properly

        // Format the deadline as YYYY-MM-DD for input field
        let formattedDeadline = deadline.toISOString().split('T')[0];

        document.getElementById("deadline").value = formattedDeadline;
    }
}

function addTask(event) {
      event.preventDefault(); // Prevent page reload
    let taskTitle = document.getElementById("taskTitle").value;
    let description = document.getElementById("description").value;
    let department = document.getElementById("department").value;
    let role = document.getElementById("role").value;
    let assignedTo = document.getElementById("assigned_to").value;
    let noOfDays = document.getElementById("noOfDays").value;
    let taskCreateDate = document.getElementById("taskCreateDate").value;
    let taskStartDate = document.getElementById("taskStartDate").value;
    let deadline = document.getElementById("deadline").value;

    if (!taskTitle || !description || !department || !role || !assignedTo || !noOfDays || !taskCreateDate || !taskStartDate) {
        alert("Please fill in all fields.");
        return;
    }

    let tableBody = document.getElementById("taskTableBody");
    let row = document.createElement("tr");

    row.innerHTML = ` 
        <td class="border px-4 py-2">${taskId++}</td>
        <td class="border px-4 py-2">${taskTitle}</td>
        <td class="border px-4 py-2">${assignedTo}</td>
        <td class="border px-4 py-2"><span class="text-yellow-500">Pending</span></td>
        <td class="border px-4 py-2">${description}</td>
        <td class="border px-4 py-2">${taskStartDate}</td>
        <td class="border px-4 py-2">${taskCreateDate}</td>
        <td class="border px-4 py-2">${noOfDays}</td>
        <td class="border px-4 py-2">
            <textarea class="w-full px-2 py-1 border rounded-lg" placeholder="Employee/Admin Message"></textarea>
        </td>
        <td class="border px-4 py-2">
            <button onclick="deleteTask(this, ${taskId})" class="px-3 py-1 bg-red-500 text-white">Delete</button>
        </td>
    `;

    tableBody.appendChild(row);
    document.getElementById("taskForm").reset();
    document.getElementById("deadline").value = "";
}
function deleteTask(button, taskId) {
    $.ajax({
        url: `/tasks/${taskId}`,
        method: "DELETE",
        data: { _token: "{{ csrf_token() }}" },
        success: function () {
            $(button).closest("tr").remove();
        },
        error: function (error) {
            console.error("Error deleting task:", error);
        }
    });
}

$(document).ready(function () {
    $("#taskForm").submit(function (event) {
        event.preventDefault(); // Prevent the form from reloading the page
        addTask();
            let formData = {
                _token: $("input[name='_token']").val(),
                task_title: $("#taskTitle").val(),
                description: $("#description").val(),
                department: $("#department").val(),
                role: $("#role").val(),
                assigned_to: $("#assigned_to").val(),
                no_of_days: $("#noOfDays").val(),
                task_create_date: $("#taskCreateDate").val(),
                task_start_date: $("#taskStartDate").val(),
                deadline: $("#deadline").val(),
            };

            $.ajax({
                url: "{{ route('tasks.store') }}",
                method: "POST",
                data: formData,
                success: function (response) {
                    let newRow = `
                        <tr>
                            <td class="border px-4 py-2">${response.id}</td>
                            <td class="border px-4 py-2">${response.task_title}</td>
                            <td class="border px-4 py-2">${response.assigned_to_name}</td>
                            <td class="border px-4 py-2"><span class="text-yellow-500">Pending</span></td>
                            <td class="border px-4 py-2">${response.description}</td>
                            <td class="border px-4 py-2">${response.task_start_date}</td>
                            <td class="border px-4 py-2">${response.task_create_date}</td>
                            <td class="border px-4 py-2">${response.no_of_days}</td>
                            <td class="border px-4 py-2"><textarea class="w-full px-2 py-1 border rounded-lg"></textarea></td>
                            <td class="border px-4 py-2">
                                <button onclick="deleteTask(this, ${response.id})" class="px-3 py-1 bg-red-500 text-white">Delete</button>
                            </td>
                        </tr>
                    `;

                    $("#taskTableBody").append(newRow);
                    $("#taskForm")[0].reset();
                    $("#deadline").val("");
                }
            });
        });
    });

//for roles and department 
     document.addEventListener("DOMContentLoaded", function () {
        let departmentSelect = document.getElementById("department");
        let roleSelect = document.getElementById("role");
        let allRoles = Array.from(roleSelect.options).slice(1); // Exclude default "Select Role"

        departmentSelect.addEventListener("change", function () {
            let selectedDept = this.value;
            roleSelect.innerHTML = '<option disabled selected>Select Role</option>'; // Reset roles

            allRoles.forEach(option => {
                if (option.getAttribute("data-department") === selectedDept) {
                    roleSelect.appendChild(option.cloneNode(true));
                }
            });
        });
    });

    //assinged to 
$(document).ready(function() {
    // Initially disable Role and Assigned To fields
    $('#role').prop('disabled', true);
    $('#assigned_to').prop('disabled', true);

    // When department is selected, enable Role dropdown
    $('#department').change(function() {
        var department = $(this).val();
        $('#role').prop('disabled', department ? false : true);
        $('#assigned_to').prop('disabled', true); // Keep Assigned To disabled

        if (department) {
            $.ajax({
                url: "{{ route('fetch.roles') }}",
                type: "GET",
                data: { department: department },
                success: function(response) {
                    $('#role').empty().append('<option selected disabled>Select Role</option>');

                    if (response.length > 0) {
                        $.each(response, function(index, role) {
                            $('#role').append('<option value="' + role + '">' + role + '</option>');
                        });
                    } else {
                        $('#role').append('<option disabled>No Roles Available</option>');
                    }
                }
            });
        }
    });
 // Prevent selecting Role without Department
    $('#role').focus(function() {
        var department = $('#department').val();
        if (!department) {
            alert("Please select a department first!");
            $('#department').focus(); // Move focus to department
            $(this).blur(); // Remove focus from role
        }
    });
    // When role is selected, enable Assigned To dropdown
    $('#role').change(function() {
        var role = $(this).val();
        $('#assigned_to').prop('disabled', role ? false : true);

        var department = $('#department').val();
        if (department && role) {
            $.ajax({
                url: "{{ route('fetch.employees') }}",
                type: "GET",
                data: { department: department, role: role },
                success: function(response) {
                    $('#assigned_to').empty().append('<option selected disabled>Select Employee</option>');

                    if (response.length > 0) {
                        $.each(response, function(index, employee) {
                            $('#assigned_to').append('<option value="' + employee.id + '">' + employee.fullname + ' (' + employee.email + ')</option>');
                        });
                    } else {
                        $('#assigned_to').append('<option disabled>No Employees Available</option>');
                    }
                }
            });
        }
    });
});
</script> --}}


<script>
    let taskId = 1;

    function calculateDeadline() {
        let startDate = document.getElementById("taskStartDate").value;
        let days = document.getElementById("noOfDays").value;

        if (startDate && days) {
            let deadline = new Date(startDate);
            deadline.setDate(deadline.getDate() + parseInt(days) - 1);

            let formattedDeadline = deadline.toISOString().split('T')[0];
            document.getElementById("deadline").value = formattedDeadline;
        }
    }

    function addTask(event) {
        event.preventDefault(); // Prevent page reload

        let taskTitle = document.getElementById("taskTitle").value;
        let description = document.getElementById("description").value;
        let department = document.getElementById("department").value;
        let role = document.getElementById("role").value;
        let assignedTo = document.getElementById("assigned_to").value;
        let noOfDays = document.getElementById("noOfDays").value;
        let taskCreateDate = document.getElementById("taskCreateDate").value;
        let taskStartDate = document.getElementById("taskStartDate").value;
        let deadline = document.getElementById("deadline").value;

        if (!taskTitle || !description || !department || !role || !assignedTo || !noOfDays || !taskCreateDate || !taskStartDate) {
            alert("Please fill in all fields.");
            return;
        }

        let formData = {
            _token: $("input[name='_token']").val(),
            task_title: taskTitle,
            description: description,
            department: department,
            role: role,
            assigned_to: assignedTo,
            no_of_days: noOfDays,
            task_create_date: taskCreateDate,
            task_start_date: taskStartDate,
            deadline: deadline,
        };

        $.ajax({
            url: "{{ route('tasks.store') }}",
            method: "POST",
            data: formData,
            success: function (response) {
                let newRow = `
                    <tr>
                        <td class="border px-4 py-2">${response.id}</td>
                        <td class="border px-4 py-2">${response.task_title}</td>
                        <td class="border px-4 py-2">${response.assigned_to_name}</td>
                        <td class="border px-4 py-2"><span class="text-yellow-500">Pending</span></td>
                        <td class="border px-4 py-2">${response.description}</td>
                        <td class="border px-4 py-2">${response.task_start_date}</td>
                        <td class="border px-4 py-2">${response.task_create_date}</td>
                        <td class="border px-4 py-2">${response.no_of_days}</td>
                        <td class="border px-4 py-2"><textarea class="w-full px-2 py-1 border rounded-lg"></textarea></td>
                        <td class="border px-4 py-2">
                            <button onclick="deleteTask(this, ${response.id})" class="px-3 py-1 bg-red-500 text-white">Delete</button>
                        </td>
                    </tr>
                `;

                $("#taskTableBody").append(newRow);
                $("#taskForm")[0].reset();
                $("#deadline").val("");
            },
            error: function (error) {
                console.error("Error adding task:", error);
            }
        });
    }

    function deleteTask(button, taskId) {
        $.ajax({
            url: `/tasks/${taskId}`,
            method: "DELETE",
            data: { _token: "{{ csrf_token() }}" },
            success: function () {
                $(button).closest("tr").remove();
            },
            error: function (error) {
                console.error("Error deleting task:", error);
            }
        });
    }

    $(document).ready(function () {
        $("#taskForm").submit(addTask); // Attach addTask function to form submit event

        // Handle Role and Department Dropdowns
        let departmentSelect = document.getElementById("department");
        let roleSelect = document.getElementById("role");
        let allRoles = Array.from(roleSelect.options).slice(1);

        departmentSelect.addEventListener("change", function () {
            let selectedDept = this.value;
            roleSelect.innerHTML = '<option disabled selected>Select Role</option>';

            allRoles.forEach(option => {
                if (option.getAttribute("data-department") === selectedDept) {
                    roleSelect.appendChild(option.cloneNode(true));
                }
            });
        });

        // Role and Assigned To Logic
        $('#role').prop('disabled', true);
        $('#assigned_to').prop('disabled', true);

        $('#department').change(function () {
            var department = $(this).val();
            $('#role').prop('disabled', !department);
            $('#assigned_to').prop('disabled', true);

            if (department) {
                $.ajax({
                    url: "{{ route('fetch.roles') }}",
                    type: "GET",
                    data: { department: department },
                    success: function (response) {
                        $('#role').empty().append('<option selected disabled>Select Role</option>');

                        if (response.length > 0) {
                            $.each(response, function (index, role) {
                                $('#role').append('<option value="' + role + '">' + role + '</option>');
                            });
                        } else {
                            $('#role').append('<option disabled>No Roles Available</option>');
                        }
                    }
                });
            }
        });

        $('#role').focus(function () {
            var department = $('#department').val();
            if (!department) {
                alert("Please select a department first!");
                $('#department').focus();
                $(this).blur();
            }
        });

        $('#role').change(function () {
            var role = $(this).val();
            $('#assigned_to').prop('disabled', !role);

            var department = $('#department').val();
            if (department && role) {
                $.ajax({
                    url: "{{ route('fetch.employees') }}",
                    type: "GET",
                    data: { department: department, role: role },
                    success: function (response) {
                        $('#assigned_to').empty().append('<option selected disabled>Select Employee</option>');

                        if (response.length > 0) {
                            $.each(response, function (index, employee) {
                                $('#assigned_to').append('<option value="' + employee.id + '">' + employee.fullname + ' (' + employee.email + ')</option>');
                            });
                        } else {
                            $('#assigned_to').append('<option disabled>No Employees Available</option>');
                        }
                    }
                });
            }
        });
    });
</script>

@endsection
