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
    <script src="{{ asset('js/tasks.js') }}"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
                height: 6px; 
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }
    </style>
</head>
<body class="bg-gray-900 text-white p-6">
    
<div class="max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-center">Task Management</h1>

    <!-- Task Creation Form -->
    <form action="{{ route('tasks.store') }}" method="POST" id="taskForm" class="mb-6 p-4 rounded-lg bg-gray-800 shadow-lg">
        @csrf

        <!-- Task Title -->
        <div class="mb-4">
            <label class="block text-white mb-2">Task Title</label>
            <input type="text" name="task_title" required class="w-full p-3 rounded text-white bg-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500">
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label class="block text-white mb-2">Description</label>
            <textarea name="description" required class="w-full p-3 rounded text-white bg-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500"></textarea>
        </div>

        <!-- Flex container for three fields -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <!-- Department -->
            <div>
                <label class="block text-white mb-2">Department</label>
                <select name="department_id" id="department_id" required class="w-full p-3 rounded text-white bg-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                    <option value="">Select Department</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Role -->
            <div>
                <label class="block text-white mb-2">Role</label>
                <select name="role_id" id="role_id" required class="w-full p-3 rounded text-white bg-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                    <option value="">Select Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Assigned To -->
            <div>
                <label class="block text-white mb-2">Assigned To</label>
                <select name="assigned_to" id="assigned_to" required class="w-full p-3 rounded text-white bg-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                    <option value="">Select Employee</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">
                            {{ $employee->full_name }} ({{ $employee->email_id }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- No. of Days -->
        <div class="mb-4">
            <label class="block text-white mb-2">No. of Days</label>
            <input type="number" name="no_of_days" id="no_of_days" required class="w-full p-3 rounded text-white bg-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500">
        </div>


        <button type="submit" id="createTaskBtn" class="mt-4 w-full px-4 py-2 bg-red-600 hover:bg-red-700 rounded text-white font-semibold">
            Create Task
        </button>
    </form>
</div>

<div class="max-w-5xl mx-auto">
    <h2 class="text-xl font-semibold mb-4">Task List</h2>
    <div class="overflow-x-auto custom-scrollbar" style="max-height: 500px; overflow-y: auto;">
        <table class="w-full text-center border-collapse">
            <thead>
                <tr class="bg-red-600 text-white text-sm">
                    <th class="p-2">ID</th>
                    <th class="p-2">Task Title</th>
                    <th class="p-2">Description</th>
                    <th class="p-2">Assigned To</th>
                    <th class="p-2">Overdue</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Redo Count</th>
                    <th class="p-2">Task Create Date</th>
                    <th class="p-2">Task Start Date</th>
                    <th class="p-2">No. of Days</th>
                    <th class="p-2">Deadline</th>
                    <th class="p-2">Task Document</th>
                    <th class="p-2">Flowchart</th>
                    <th class="p-2">Sheet Detail</th>
                    <th class="p-2">Admin Feedback</th>
{{-- 
                    <th class="p-2">Remarks</th> --}}
                    <th class="p-2">Score</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody id="task-table-body" class="text-sm">
                @foreach ($tasks as $task)
                    <tr class="bg-gray-800 hover:bg-gray-700 text-white">
                        <td class="p-2">{{ $task->id }}</td>
                        <td class="p-2">{{ $task->task_title }}</td>
                        <td class="p-2">{{ $task->description }}</td>
                        <td class="p-2">{{ $task->employee->email_id ?? 'Not Assigned' }}</td>
<td class="p-2">
@php
    $overdue = 0;
    $penalty = 0;

    if ($task->task_start_date && $task->deadline && $task->no_of_days) {
        $deadline = \Carbon\Carbon::parse($task->deadline);  
        $now = $task->status === 'Completed' && $task->updated_at ? $task->updated_at : now();

        if ($deadline->isPast()) {
            $overdue = $deadline->diffInDays($now, false);
            $overdue = max($overdue, 0);
        }
    }

    // Round the overdue days to the nearest whole number
    $overdue = floor($overdue);

    // Calculate penalty (-30 per day)
    $penalty = $overdue * -30;
@endphp

<span>{{ $overdue }} day(s)</span><br>




    {{-- <span class="text-red-600">Score: {{ $penalty }}</span> --}}
</td>



<td class="p-2">
    @if (Auth::guard('admin')->check() && $task->status !== 'Completed')
        <select class="p-1 text-black rounded status-select" data-task-id="{{ $task->id }}">
            <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Started" {{ $task->status == 'Started' ? 'selected' : '' }}>Started</option>
            <option value="Review" {{ $task->status == 'Review' ? 'selected' : '' }}>Review</option>
            <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
        </select>
    @else
        <span>{{ $task->status }}</span>
        @if ($task->status === 'Completed' && $task->completed_at)
            <br>
            <small class="text-green-400">Completed at: {{ \Carbon\Carbon::parse($task->completed_at)->format('d M Y, h:i A') }}</small>
        @endif
    @endif
</td>


                        <td class="p-2">
                            <span class="redo-count">{{ $task->redo_count ?? 0 }}</span>
                            @if (Auth::guard('employee')->check() && $task->status == 'Review')
                                <button class="px-2 py-1 bg-red-600 text-white rounded redo-btn" data-task-id="{{ $task->id }}">Redo</button>
                            @endif
                        </td>
                        <td class="p-2">{{ $task->task_create_date }}</td>
                        <td class="p-2">
                            <input type="date" class="w-full p-1 rounded text-white task-start-date" 
                                   value="{{ $task->task_start_date }}" data-task-id="{{ $task->id }}"
                                   @if(Auth::guard('employee')->check() && $task->task_start_date) disabled @endif />
                        </td>
                        <td class="p-2">
                            <input type="number" class="w-full p-1 rounded text-black bg-white border border-white no-of-days-input" 
                                   value="{{ $task->no_of_days }}" data-task-id="{{ $task->id }}" 
                                   @if($task->no_of_days) readonly @endif />
                        </td>
                        <td class="p-2">
                            <input type="date" readonly class="w-full p-1 rounded text-white bg-gray-700 task-deadline" 
                                   value="{{ $task->deadline }}" id="deadline-{{ $task->id }}" data-task-id="{{ $task->id }}" />
                        </td>
                        <td class="p-2">
                            @if($task->task_document)
                                <a href="{{ asset('storage/' . $task->task_document) }}" target="_blank" class="text-blue-400 underline">View</a>
                            @else
                                <span class="text-gray-400">Not Uploaded</span>
                            @endif
                        </td>
                        <td class="p-2">
                            @if($task->flowchart)
                                <a href="{{ asset('storage/' . $task->flowchart) }}" target="_blank" class="text-blue-400 underline">View</a>
                            @else
                                <span class="text-gray-400">Not Uploaded</span>
                            @endif
                        </td>
                        <td class="p-2">
                            @if($task->sheet_detail)
                                <a href="{{ asset('storage/' . $task->sheet_detail) }}" target="_blank" class="text-blue-400 underline">View</a>
                            @else
                                <span class="text-gray-400">Not Uploaded</span>
                            @endif
                        </td>
                        
<td class="p-2">
    @if(Auth::guard('admin')->check())
        <form method="POST" action="{{ route('tasks.uploadFeedback', $task->id) }}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="feedback_image" accept="image/*" class="mb-1 text-white" />
            <textarea name="feedback_note" class="w-full p-1 rounded text-black bg-white border border-white mb-1" placeholder="Write feedback...">{{ $task->feedback_note }}</textarea>
<button type="submit" class="mt-1">
    <img src="{{ asset('build/assets/img/upload.png') }}" alt="Upload" class="w-5 h-5 inline"
         style="filter: invert(48%) sepia(94%) saturate(2977%) hue-rotate(102deg) brightness(93%) contrast(89%);">
</button>


        </form>

        {{-- Show current feedback below the form --}}
        @if($task->feedback_image || $task->feedback_note)
            <div class="mt-2 p-2 bg-gray-800 rounded">
                <p class="text-white font-semibold mb-1">Uploaded Feedback:</p>
                @if($task->feedback_image)
                    <a href="{{ asset('storage/' . $task->feedback_image) }}" target="_blank" class="text-blue-400 underline">View Feedback Image</a><br>
                @endif
                @if($task->feedback_note)
                    <p class="text-white mt-1"><strong>Note:</strong> {{ $task->feedback_note }}</p>
                @endif
            </div>
        @endif
    @else
        {{-- Employee View --}}
        @if($task->feedback_image)
            <a href="{{ asset('storage/' . $task->feedback_image) }}" target="_blank" class="text-blue-400 underline">View Feedback Image</a><br>
        @endif
        <span class="text-white">{{ $task->feedback_note }}</span>
    @endif
</td>


                        {{-- <td class="p-2">
                            <textarea class="w-full p-1 rounded text-black remark-input" data-task-id="{{ $task->id }}">{{ $task->remarks }}</textarea>
                            <button class="px-2 py-1 bg-blue-600 text-white rounded mt-2 save-remark-btn" data-task-id="{{ $task->id }}">Save</button>
                        </td> --}}
                        <td class="p-2">
                            @if(Auth::guard('admin')->check() && $task->status === 'Completed')
                                <form method="POST" action="{{ route('tasks.updateScore', $task->id) }}">
                                    @csrf
                                    @php
                                        $score = $task->score ?? 0;
                                        if ($overdue > 0) {
                                            $score -= $overdue * 30;
                                        }
                                    @endphp
                                    <input type="number" name="score" value="{{ $score }}" 
                                           class="w-20 p-1 rounded text-black bg-white border border-white" min="0" />
                                    <button type="submit" class="px-2 py-1 bg-green-600 text-white rounded ml-2">Save</button>
                                </form>
                            @else
                                <span>{{ $task->score ?? 0 }}</span>
                            @endif
                        </td>
                        <td class="p-2">
                            <form class="task-delete-form" data-task-id="{{ $task->id }}">
                                @csrf
                                <button type="button" class="px-2 py-1 bg-red-600 text-white rounded delete-task-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


</body>
</html>


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
    $(document).ready(function () {
        // 🔁 Prevent binding the event multiple times
        $(document).off('submit', '#taskForm');

        // Employee Dropdown by Role
        $('#role_id').change(function () {
            let roleId = $(this).val();

            if (roleId) {
                $.ajax({
                    url: "{{ route('getEmployeesByRole') }}",
                    type: "GET",
                    data: { role_id: roleId },
                    success: function (response) {
                        let assignedToDropdown = $('#assigned_to');
                        assignedToDropdown.empty();
                        assignedToDropdown.append('<option value="">Select Employee</option>');

                        response.forEach(function (employee) {
                            assignedToDropdown.append(
                                `<option value="${employee.id}">${employee.full_name} (${employee.email_id})</option>`
                            );
                        });
                    },
                    error: function (xhr) {
                        console.error('Error fetching employees:', xhr.responseText);
                    }
                });
            }
        });

        // 🚀 AJAX Form Submission
        $('#taskForm').submit(function (e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('tasks.store') }}",
                method: "POST",
                data: formData,
                success: function (response) {
                    alert('✅ Task created successfully!');
                    $('#taskForm')[0].reset();

if (response.task) {
    $('#task-table-body').append(`
<tr class="bg-gray-900 hover:bg-gray-700 text-white">
    <td class="p-2">${response.task.id}</td>
    <td class="p-2">${response.task.task_title}</td>
    <td class="p-2">${response.task.description}</td>
    <td class="p-2">${response.employee?.email_id ?? 'Not Assigned'}</td>
    <td class="p-2"><span>0 day(s)</span></td>
    <td class="p-2">
        <select class="p-1 text-black rounded status-select" data-task-id="${response.task.id}">
            <option value="Pending">Pending</option>
            <option value="Started">Started</option>
            <option value="Review">Review</option>
            <option value="Completed">Completed</option>
        </select>
    </td>
    <td class="p-2">
        <span class="redo-count">0</span>
        ${response.role === 'employee' ? `<button class="px-2 py-1 bg-red-600 text-white rounded redo-btn" data-task-id="${response.task.id}">Redo</button>` : ''}
    </td>
    <td class="p-2">${response.task.task_create_date ?? '-'}</td>
    <td class="p-2">
        <input type="date" class="w-full p-1 rounded text-white task-start-date" 
            value="${response.task.task_start_date ?? ''}" data-task-id="${response.task.id}" />
    </td>
    <td class="p-2">
        <input type="number" class="w-full p-1 rounded text-black bg-white border border-white no-of-days-input" 
            value="${response.task.no_of_days ?? ''}" data-task-id="${response.task.id}" />
    </td>
    <td class="p-2">
        <input type="date" readonly class="w-full p-1 rounded text-white bg-gray-700 task-deadline" 
            value="${response.task.deadline ?? ''}" data-task-id="${response.task.id}" />
    </td>
    <td class="p-2"><span class="text-gray-400">Not Uploaded</span></td>
    <td class="p-2"><span class="text-gray-400">Not Uploaded</span></td>
    <td class="p-2"><span class="text-gray-400">Not Uploaded</span></td>
    <td class="p-2">
        ${response.role === 'admin' ? `
            <form method="POST" action="/tasks/upload-feedback/${response.task.id}" enctype="multipart/form-data">
                <input type="file" name="feedback_image" accept="image/*" class="mb-1 text-white" />
                <textarea name="feedback_note" class="w-full p-1 rounded text-black bg-white border border-white mb-1" placeholder="Write feedback..."></textarea>
                <button type="submit" class="mt-1">
                    <img src="/build/assets/img/upload.png" alt="Upload" class="w-5 h-5 inline"
                        style="filter: invert(48%) sepia(94%) saturate(2977%) hue-rotate(102deg) brightness(93%) contrast(89%);">
                </button>
            </form>
        ` : `<span class="text-white">-</span>`}
    </td>
    <td class="p-2">
        ${response.role === 'admin' ? `
            <form method="POST" action="/tasks/update-score/${response.task.id}">
                <input type="number" name="score" value="0" class="w-20 p-1 rounded text-black bg-white border border-white" min="0" />
                <button type="submit" class="px-2 py-1 bg-green-600 text-white rounded ml-2">Save</button>
            </form>
        ` : `<span>0</span>`}
    </td>
    <td class="p-2">
        <form class="task-delete-form" data-task-id="${response.task.id}">
            <button type="button" class="px-2 py-1 bg-red-600 text-white rounded delete-task-btn">Delete</button>
        </form>
    </td>
</tr>
`);

}


                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('❌ Error creating task.');
                }
            });
        });
    });

//calculate deadline based on no_od_days
document.querySelectorAll('.task-start-date').forEach(input => {
    input.addEventListener('change', function() {
        const taskId = this.getAttribute('data-task-id');
        const startDateValue = this.value;
        const noOfDaysElement = document.querySelector(`#no_of_days-${taskId}`);
        const deadlineElement = document.querySelector(`#deadline-${taskId}`);
        const deadlineDisplay = document.querySelector(`#deadline-display-${taskId}`); // Table display

        if (!noOfDaysElement || !deadlineElement || !deadlineDisplay) {
            console.error(`Error: Missing elements for taskId: ${taskId}`);
            return;
        }

        if (!startDateValue) {
            console.error(`Error: Invalid start date for taskId: ${taskId}`);
            return;
        }

        // Convert start date to a Date object
        const startDate = new Date(startDateValue);

        // Get no_of_days value correctly
        const noOfDays = parseInt(noOfDaysElement.value, 10);
        if (isNaN(noOfDays)) {
            console.error(`Error: Invalid number of days for taskId: ${taskId}`);
            return;
        }

        // Calculate deadline by adding no_of_days to startDate and subtracting 1 day
        const deadlineDate = new Date(startDate);
        deadlineDate.setDate(deadlineDate.getDate() + noOfDays - 1);

        // Format deadline as YYYY-MM-DD
        const deadlineFormatted = deadlineDate.toISOString().split('T')[0];

        // Update the deadline input field and table display
        deadlineElement.value = deadlineFormatted;
        deadlineDisplay.textContent = deadlineFormatted;

        // Send AJAX request to save the new deadline in the database
        fetch(`/employee/task/update-deadline/${taskId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ deadline: deadlineFormatted })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Deadline updated successfully');
            } else {
                console.error('Failed to update deadline');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});





//stauts
$(document).ready(function () {
    $(".status-select").change(function () {
        let taskId = $(this).data("task-id");
        let newStatus = $(this).val();
        let $this = $(this); // Reference to the dropdown

        $.ajax({
            url: "/tasks/" + taskId + "/update-status", // Adjust route as needed
            type: "PATCH",
            data: {
                _token: "{{ csrf_token() }}",
                status: newStatus
            },
            success: function (response) {
                let bgColor = "";
                if (newStatus === "Pending") bgColor = "bg-yellow-500";
                else if (newStatus === "Started") bgColor = "bg-blue-500";
                else if (newStatus === "Completed") bgColor = "bg-green-500";
                else if (newStatus === "Review") bgColor = "bg-orange-500";

                // Apply background color directly to the dropdown
                $this.removeClass().addClass(`p-1 text-black rounded status-select ${bgColor}`);
            },
            error: function () {
                alert("Error updating status. Please try again.");
            }
        });
    });
});


// Bind task-start-date change event again
document.querySelectorAll('.task-start-date').forEach(input => {
    input.addEventListener('change', function () {
        const taskId = this.getAttribute('data-task-id');
        const startDate = new Date(this.value);
        const noOfDaysElement = document.querySelector(`#no_of_days-${taskId}`);
        const deadlineElement = document.querySelector(`#deadline-${taskId}`);

        if (!noOfDaysElement || !deadlineElement) {
            console.error("Missing inputs for task", taskId);
            return;
        }

        const noOfDays = parseInt(noOfDaysElement.value || 0);
        const deadlineDate = new Date(startDate);
        deadlineDate.setDate(deadlineDate.getDate() + noOfDays);

        const formatted = deadlineDate.toISOString().split('T')[0];
        deadlineElement.value = formatted;
    });
});



 
//delete
$(document).ready(function () {
    $(document).on("click", ".delete-task-btn", function () {
        const form = $(this).closest("form");
        const taskId = form.data("task-id");
        const row = form.closest("tr");

        if (confirm("Are you sure you want to delete this task?")) {
            $.ajax({
                url: `/tasks/${taskId}`,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function (response) {
                    if (response.success) {
                        alert("delete successfully"); // Optional alert
                        row.fadeOut(300, function () {
                            $(this).remove();
                        });
                    } else {
                        alert("Error: " + response.message);
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert("An error occurred while deleting the task.");
                }
            });
        }
    });
});




//redo count
$(document).ready(function () {
 $('.redo-btn').off('click').on('click', function () {
    const taskId = $(this).data('task-id');
    const button = $(this);
    const redoCountCell = button.closest("td").find("span.redo-count");
    const statusSelect = $("#status-" + taskId);
    const statusText = $("#status-text-" + taskId);
    const scoreSpan = $("#score-" + taskId);
window.API_BASE_URL = "{{ env('MIX_API_URL') }}";
   console.log("API Base URL:", API_BASE_URL);
   let $api_url = window.API_BASE_URL + "/tasks/redo";
    $.ajax({
        url: $api_url, // Updated URL to match scoreboard route

        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            task_id: taskId
        },
        success: function (response) {
            redoCountCell.text(response.redo_count ?? 0);
            if (scoreSpan.length) scoreSpan.text(response.score);
            if (statusSelect.length) statusSelect.val(response.status);
            else if (statusText.length) statusText.text(response.status);
        },
        error: function (error) {
            alert("Error updating redo count!");
        }
    });
});

});


    $(document).ready(function() {
    $('.status-select').on('change', function() {
        let taskId = $(this).data('task-id');
        let newStatus = $(this).val();

        // If the new status is 'Completed', hide the redo button
        if (newStatus === 'Completed') {
            $('.redo-btn[data-task-id="' + taskId + '"]').hide();
        }
    });
});



    document.querySelectorAll('.status-select').forEach(function(select) {
        select.addEventListener('change', function() {
            const taskId = this.dataset.taskId;
            const newStatus = this.value;

            fetch(`/admin/tasks/update-status/${taskId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Task status updated successfully!");
                    location.reload(); // Optional: reload to show "Completed at" if displayed
                } else {
                    alert("Failed to update task status.");
                }
            });
        });
    });
</script>

</body>
</html>
