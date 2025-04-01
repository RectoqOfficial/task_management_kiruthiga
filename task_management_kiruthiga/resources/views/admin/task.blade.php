<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body class="bg-black text-white p-6">

    <div class="max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-center">Task Management</h1>

        <!-- Task Creation Form -->
        <form action="{{ route('tasks.store') }}" method="POST" id="taskForm" class="mb-6 bg-gray-800 p-4 rounded-lg">
            @csrf
            <label class="block mb-2">Task Title</label>
            <input type="text" name="task_title" required class="w-full p-2 rounded text-black">

            <label class="block mt-4 mb-2">Description</label>
            <textarea name="description" required class="w-full p-2 rounded text-black"></textarea>

            <label class="block mt-4 mb-2">Department</label>
            <select name="department_id" id="department_id" required class="w-full p-2 rounded text-black">
                <option value="">Select Department</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>

            <label class="block mt-4 mb-2">Role</label>
            <select name="role_id" id="role_id" required class="w-full p-2 rounded text-black">
                <option value="">Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>

            <label class="block mt-4 mb-2">Assigned To</label>
            <select name="assigned_to" id="assigned_to" required class="w-full p-2 rounded text-black">
                <option value="">Select Employee</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">
                        {{ $employee->full_name }} ({{ $employee->email_id }})
                    </option>
                @endforeach
            </select>

            <label class="block mt-4 mb-2">Task Start Date</label>
            <input type="date" name="task_start_date" id="task_start_date" required class="w-full p-2 rounded text-black">

            <label class="block mt-4 mb-2">No. of Days</label>
            <input type="number" name="no_of_days" id="no_of_days" required class="w-full p-2 rounded text-black">

            <label class="block mt-4 mb-2">Deadline</label>
            <input type="date" name="deadline" id="deadline" readonly class="w-full p-2 rounded text-black">

            <button type="submit" class="mt-4 w-full px-4 py-2 bg-red-600 hover:bg-red-700 rounded">
                Create Task
            </button>
        </form>
    </div>

    <div class="bg-gray-800 p-4 rounded-lg">
        <h2 class="text-xl font-semibold mb-4">Task List</h2>
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-600 text-center">
                <thead>
                    <tr class="bg-[#ff0003] text-white">
                        <th class="border border-gray-600 p-2">ID</th>
                        <th class="border border-gray-600 p-2">Task Title</th>
                        <th class="border border-gray-600 p-2">Description</th>
                        <th class="border border-gray-600 p-2">Assigned To</th>
                        <th class="border border-gray-600 p-2">Status</th>
                        <th class="border border-gray-600 p-2">Task Create Date</th>
                        <th class="border border-gray-600 p-2">Task Start Date</th>
                        <th class="border border-gray-600 p-2">No. of Days</th>
                        <th class="border border-gray-600 p-2">Deadline</th>
                        <th class="border border-gray-600 p-2">Actions</th>
                    </tr>
                </thead>
<tbody>
    @foreach ($tasks as $task)
        <tr class="bg-gray-900 hover:bg-gray-700">
            <td class="border border-gray-600 p-2">{{ $task->id }}</td>
            <td class="border border-gray-600 p-2">{{ $task->task_title }}</td>
            <td class="border border-gray-600 p-2">{{ $task->description }}</td>
            <td class="border border-gray-600 p-2">{{ $task->employee->email_id ?? 'Not Assigned' }}</td>
            <td class="border border-gray-600 p-2">
                <span class="px-2 py-1 text-black rounded 
                    @if($task->status == 'Pending') bg-yellow-500 
                    @elseif($task->status == 'Started') bg-blue-500 
                    @elseif($task->status == 'Completed') bg-green-500 
                    @elseif($task->status == 'Review') bg-orange-500 
                    @endif">
                    {{ $task->status }}
                </span>
            </td>
            <td class="border border-gray-600 p-2">{{ $task->task_create_date }}</td>
            <td class="border border-gray-600 p-2">
                <input type="date" name="task_start_date" value="{{ $task->task_start_date }}" class="w-full p-1 rounded text-black" />
            </td>
            <td class="border border-gray-600 p-2">{{ $task->no_of_days }}</td>
            <td class="border border-gray-600 p-2">{{ $task->deadline }}</td>
            <td class="border border-gray-600 p-2">
                <!-- Status Dropdown with Default as "Pending" -->
                <form class="status-update-form" data-task-id="{{ $task->id }}">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="p-1 text-black rounded status-select" data-task-id="{{ $task->id }}">
                        <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Started" {{ $task->status == 'Started' ? 'selected' : '' }}>Started</option>
                        <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Review" {{ $task->status == 'Review' ? 'selected' : '' }}>Review</option>
                    </select>
                    <button type="submit" class="px-2 py-1 bg-green-600 text-white rounded ml-2">Update</button>
                </form>
                <!-- Delete Button (Only Visible for Admins) -->
                {{-- @if(auth()->check() && auth()->user()->role == 'admin') --}}
                   <form id="delete-task-form-{{ $task->id }}" method="POST" style="display:inline-block;" class="task-delete-form">
    @csrf
    @method('DELETE')
    <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded ml-2" onclick="deleteTask(event, {{ $task->id }})">Delete</button>
</form>
                {{-- @endif --}}
            </td>
        </tr>
    @endforeach
</tbody>

            </table>
        </div>
    </div>



    <script>
        document.getElementById('department_id').addEventListener('change', function() {
            fetch('/get-roles-by-department?department_id=' + this.value)
                .then(response => response.json())
                .then(data => {
                    let roleSelect = document.getElementById('role_id');
                    roleSelect.innerHTML = '<option value="">Select Role</option>';
                    data.forEach(role => {
                        let option = new Option(role.name, role.id);
                        roleSelect.appendChild(option);
                    });
                });
        });

        document.getElementById('role_id').addEventListener('change', function() {
            let roleId = this.value;

            if (roleId) {
                fetch(`/get-employees-by-role?role_id=${roleId}`)
                    .then(response => response.json())
                    .then(data => {
                        let employeeSelect = document.getElementById('assigned_to');
                        employeeSelect.innerHTML = '<option value="">Select Employee</option>';

                        data.forEach(employee => {
                            let option = new Option(employee.email, employee.id);
                            employeeSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching employees:', error));
            }
        });

        document.getElementById('task_start_date').addEventListener('change', calculateDeadline);
        document.getElementById('no_of_days').addEventListener('input', calculateDeadline);

        function calculateDeadline() {
            let startDate = document.getElementById('task_start_date').value;
            let days = document.getElementById('no_of_days').value;

            if (startDate && days) {
                let deadline = new Date(startDate);
                deadline.setDate(deadline.getDate() + parseInt(days));
                document.getElementById('deadline').value = deadline.toISOString().split('T')[0];
            }
        }
    // Update Task Status AJAX
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".status-update-form").forEach(form => {
        form.addEventListener("submit", function(event) {
            event.preventDefault();  // Prevent page reload

            let taskId = this.dataset.taskId;  // Get task ID from the form data attribute
            let statusSelect = this.querySelector(".status-select");  // Get the status dropdown
            let newStatus = statusSelect.value;  // Get the selected status
            let formData = new FormData(this);  // Form data (this can include other inputs too)
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

            // Append the new status manually to FormData
            formData.append('status', newStatus);

            // Send AJAX request to update the task status
            fetch(`/tasks/${taskId}`, {
                method: "PATCH",  // Use PATCH method
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the task status cell without reloading
                    let statusCell = document.querySelector(`tr[data-task-id='${taskId}'] td.status`);
                    if (statusCell) {
                        statusCell.innerHTML = `<span class="px-2 py-1 text-black rounded bg-${getStatusColor(newStatus)}">${newStatus}</span>`;
                    }
                    alert("Task status updated successfully!");
                } else {
                    alert("Failed to update status: " + data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("An error occurred while updating the task status.");
            });
        });
    });

    // Utility function to get color based on status
    function getStatusColor(status) {
        switch (status) {
            case 'Pending': return 'yellow-500';
            case 'Started': return 'blue-500';
            case 'Completed': return 'green-500';
            case 'Review': return 'orange-500';
            default: return 'gray-500';
        }
    }
});



$(document).on('submit', '#taskForm', function(event) {
    event.preventDefault(); 

    let formData = $(this).serialize(); 
    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                alert(response.message); // Display success message from the response
                // Optionally update the UI to reflect the newly created task
            } else {
                alert(response.message); // Display error message from the response
            }
        },
        error: function(error) {
            alert('Error submitting task');
            console.log(error); // Log the error for debugging purposes
        }
    });
});






    function deleteTask(event, taskId) {
        event.preventDefault();

        // Use AJAX to send the DELETE request
        $.ajax({
            url: '/tasks/' + taskId,
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                alert(response.message);
                // Optionally, remove the task from the table or reload the page
                $('#task-row-' + taskId).remove();
            },
            error: function(response) {
                alert('Error deleting task: ' + response.responseJSON.message);
            }
        });
    }


    </script>
</body>
</html>
