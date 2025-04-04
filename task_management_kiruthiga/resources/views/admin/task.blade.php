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

</head>
<body class="bg-black text-white p-6">
<div class="max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-center">Task Management</h1>

    <!-- Task Creation Form -->
    <form action="{{ route('tasks.store') }}" method="POST" id="taskForm" class="mb-6 bg-gray-800 p-4 rounded-lg">
        @csrf

        <!-- Task Title -->
        <div class="mb-4">
            <label class="block text-white mb-2">Task Title</label>
            <input type="text" name="task_title" required class="w-full p-3 rounded text-white bg-gray-700">
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label class="block text-white mb-2">Description</label>
            <textarea name="description" required class="w-full p-3 rounded text-white bg-gray-700"></textarea>
        </div>

        <!-- Flex container for three fields -->
        <div class="flex space-x-4 mb-4">
            <!-- Department -->
            <div class="flex-1">
                <label class="block text-white mb-2">Department</label>
                <select name="department_id" id="department_id" required class="w-full p-3 rounded text-white bg-gray-700">
                    <option value="">Select Department</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Role -->
            <div class="flex-1">
                <label class="block text-white mb-2">Role</label>
                <select name="role_id" id="role_id" required class="w-full p-3 rounded text-white bg-gray-700">
                    <option value="">Select Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Assigned To -->
            <div class="flex-1">
                <label class="block text-white mb-2">Assigned To</label>
                <select name="assigned_to" id="assigned_to" required class="w-full p-3 rounded text-white bg-gray-700">
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
            <input type="number" name="no_of_days" id="no_of_days" required class="w-full p-3 rounded text-white bg-gray-700">
        </div>

       <button type="submit" id="createTaskBtn" onclick="console.log('Create Task Clicked');" class="mt-4 w-full px-4 py-2 bg-red-600 hover:bg-red-700 rounded">
    Create Task
</button>

    </form>
</div>
<div class="max-w-5xl mx-auto">
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
                     <th class="border border-gray-600 p-2">Redo Count</th>
                    <th class="border border-gray-600 p-2">Task Create Date</th>
                    <th class="border border-gray-600 p-2">Task Start Date</th>
                    <th class="border border-gray-600 p-2">No. of Days</th>
                    <th class="border border-gray-600 p-2">Deadline</th>
                    <th class="border border-gray-600 p-2">Remarks</th>
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
    @if (auth()->check() && auth()->user()->role == 'Employee') 
        <select id="status-{{ $task->id }}" class="p-1 text-black rounded status-select" data-task-id="{{ $task->id }}">
            <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Started" {{ $task->status == 'Started' ? 'selected' : '' }}>Started</option>
            <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
            <option value="Review" {{ $task->status == 'Review' ? 'selected' : '' }}>Review</option>
        </select>
    @else
        <span id="status-text-{{ $task->id }}">{{ $task->status }}</span>
    @endif
</td>

<!-- Redo Count Column -->
<td class="border border-gray-600 p-2">
    <span class="redo-count">{{ $task->redo_count ?? 0 }}</span>
    
    @if (Auth::guard('employee')->check() && $task->status == 'Review')
        <!-- Show Redo button only when employee is logged in and status is 'Review' -->
        <button class="px-2 py-1 bg-red-600 text-white rounded redo-btn" data-task-id="{{ $task->id }}">
            Redo
        </button>
    @endif
</td>



                        <td class="border border-gray-600 p-2">{{ $task->task_create_date }}</td>
                        <td class="border border-gray-600 p-2">
                            <input type="date" name="task_start_date" id="task_start_date-{{ $task->id }}" value="{{ $task->task_start_date }}" class="w-full p-1 rounded text-black task-start-date" data-task-id="{{ $task->id }}" />
                        </td>
<td class="border border-gray-600 p-2">
    <input type="number" name="no_of_days" id="no_of_days-{{ $task->id }}" value="{{ $task->no_of_days }}" class="w-full p-1 rounded text-white no-of-days-input" data-task-id="{{ $task->id }}" />
</td>

                        <td class="border border-gray-600 p-2">
                            <input type="date" name="deadline" id="deadline-{{ $task->id }}" value="{{ $task->deadline }}" readonly class="w-full p-1 rounded text-white bg-gray-700 task-deadline" data-task-id="{{ $task->id }}" />
                        </td>
<td class="border border-gray-600 p-2">
    <textarea class="w-full p-1 rounded text-black remark-input" data-task-id="{{ $task->id }}">{{ $task->remarks }}</textarea>
    <button class="px-2 py-1 bg-blue-600 text-white rounded mt-2 save-remark-btn" data-task-id="{{ $task->id }}">
        Save
    </button>
</td>

                        <td class="border border-gray-600 p-2">
                            <form class="task-delete-form" data-task-id="{{ $task->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="px-2 py-1 bg-red-600 text-white rounded ml-2 delete-task-btn">
                                    Delete
                                </button>
                            </form>
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

$(document).ready(function () {
    $('#role_id').change(function () {
        let roleId = $(this).val();

        if (roleId) {
         $.ajax({
    url: "{{ route('getEmployeesByRole') }}", // Ensure this is inside a Blade file
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


//submit buttton
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
                alert(response.message);  
               
            } else {
                alert("Error creating task.");
            }
        },
        error: function(xhr) {
            alert("Something went wrong! Check console.");
            console.log(xhr.responseText);
        }
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


document.querySelectorAll('.task-start-date').forEach(input => {
    input.addEventListener('change', function() {
        const taskId = this.getAttribute('data-task-id');
        const startDate = new Date(this.value);
        const noOfDaysElement = document.querySelector(`#no_of_days-${taskId}`);
        const deadlineElement = document.querySelector(`#deadline-${taskId}`);

        if (!noOfDaysElement) {
            console.error(`Error: Element with id="no_of_days-${taskId}" not found.`);
            return;
        }
        if (!deadlineElement) {
            console.error(`Error: Element with id="deadline-${taskId}" not found.`);
            return;
        }
        if (isNaN(startDate.getTime())) {
            console.error(`Error: Invalid start date selected.`);
            return;
        }

        const noOfDays = parseInt(noOfDaysElement.textContent);
        const deadlineDate = new Date(startDate);
        deadlineDate.setDate(deadlineDate.getDate() + noOfDays);

        // Format deadline as YYYY-MM-DD
        const deadlineFormatted = deadlineDate.toISOString().split('T')[0];

        // Update the deadline field
        deadlineElement.value = deadlineFormatted;

        console.log(`Task ${taskId}: Start Date - ${this.value}, Deadline - ${deadlineFormatted}`);
    });
});


 


    //delet 
    $(document).ready(function () {
    $(document).on("click", ".delete-task-btn", function () {
        let taskId = $(this).closest("form").data("task-id");
        let $row = $(this).closest("tr"); // Get the row for removal

        if (confirm("Are you sure you want to delete this task?")) {
            $.ajax({
                url: "/tasks/" + taskId + "/delete", // Adjust route if needed
                type: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (response.success) {
                        $row.fadeOut(500, function () {
                            $(this).remove(); // Remove the row from the table
                        });
                    } else {
                        alert("Failed to delete task.");
                    }
                },
                error: function () {
                    alert("Error occurred while deleting task.");
                }
            });
        }
    });
});


//filter
$(document).ready(function () {
    // Listen for the filter form submission
    $('#taskFilterForm').on('submit', function (e) {
        e.preventDefault(); // Prevent form submission

        // Get the values from the filters
        let taskTitle = $('#filter_task_title').val().toLowerCase();
        let assignedTo = $('#filter_assigned_to').val();
        let status = $('#filter_status').val();

        // Loop through each table row and hide/show based on filter criteria
        $('table tbody tr').each(function () {
            let taskRow = $(this);
            let taskTitleCell = taskRow.find('td:nth-child(2)').text().toLowerCase();
            let assignedToCell = taskRow.find('td:nth-child(4)').text().toLowerCase();
            let statusCell = taskRow.find('td:nth-child(5)').text().toLowerCase();

            let showRow = true;

            // Check if the row matches the taskTitle filter
            if (taskTitle && !taskTitleCell.includes(taskTitle)) {
                showRow = false;
            }

            // Check if the row matches the assignedTo filter
            if (assignedTo && !assignedToCell.includes(assignedTo)) {
                showRow = false;
            }

            // Check if the row matches the status filter
            if (status && !statusCell.includes(status)) {
                showRow = false;
            }

            // Show or hide the row based on filter results
            if (showRow) {
                taskRow.show();
            } else {
                taskRow.hide();
            }
        });
    });
});
$('#filter_task_title').on('keyup', function () {
    let searchText = $(this).val().toLowerCase();
    $('table tbody tr').each(function () {
        let taskTitle = $(this).find('td:nth-child(2)').text().toLowerCase();
        if (taskTitle.includes(searchText)) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
});
//update remarks
document.querySelectorAll('.save-remark-btn').forEach(button => {
    button.addEventListener('click', function() {
        const taskId = this.getAttribute('data-task-id');
        const remarkInput = document.querySelector(`.remark-input[data-task-id="${taskId}"]`);
        const remarks = remarkInput.value;

        fetch(`/tasks/${taskId}/update-remarks`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ remarks })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Remark updated successfully');
            } else {
                alert('Failed to update remark');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
//redo count
    $(document).ready(function () {
        $(".redo-btn").click(function () {
            var taskId = $(this).data("task-id");
            var button = $(this);
            var redoCountCell = button.closest("td").find("span.redo-count");
            var statusSelect = $("#status-" + taskId); // Get status dropdown (if available)
            var statusText = $("#status-text-" + taskId); // Get status text (for Admin)

            $.ajax({
                url: "{{ route('tasks.redo') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    task_id: taskId
                },
                success: function (response) {
                    redoCountCell.text(response.redo_count);

                    // Update status to 'Pending' dynamically
                    if (statusSelect.length) {
                        statusSelect.val("Pending"); // For employees (dropdown)
                    } else {
                        statusText.text("Pending"); // For Admin (text)
                    }
                },
                error: function (error) {
                    alert("Error updating redo count!");
                    console.log(error);
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

    </script>
</body>
</html>
