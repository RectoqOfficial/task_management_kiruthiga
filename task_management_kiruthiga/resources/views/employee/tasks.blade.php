@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold text-white mb-4">My Tasks</h2>
     <div class="max-w-5xl mx-auto overflow-x-auto" style="max-height: 500px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 #444;">
    
        <table class="w-full text-center">
            <thead>
                <tr class="bg-[#ff0003] text-white text-sm">
                    <th class="p-2 whitespace-nowrap min-w-[60px]">ID</th>
                    <th class="p-2 whitespace-nowrap min-w-[120px]">Task Title</th>
                    <th class="p-2 whitespace-nowrap min-w-[160px]">Description</th>
                    <th class="p-2 whitespace-nowrap min-w-[140px]">Assigned To</th>
                    <th class="p-2 whitespace-nowrap min-w-[100px]">Status</th>
                    <th class="p-2 whitespace-nowrap min-w-[130px]">Redo Count</th>
                    <th class="p-2 whitespace-nowrap min-w-[160px]">Task Create Date</th>
                    <th class="p-2 whitespace-nowrap min-w-[160px]">Task Start Date</th>
                    <th class="p-2 whitespace-nowrap min-w-[130px]">No. of Days</th>
                    <th class="p-2 whitespace-nowrap min-w-[120px]">Deadline</th>
                    <th class="p-2 whitespace-nowrap min-w-[140px]">Remarks</th>
                    <th class="p-2 whitespace-nowrap min-w-[100px]">Actions</th>
                </tr>
            </thead>
            <tbody id="task-table-body" class="text-sm">
                @foreach ($tasks as $task)
                    <tr class="bg-gray-900 hover:bg-gray-700 text-white">
                                             <td class="p-2">
    <input 
        type="number" 
        class="w-full p-1 rounded text-white no-of-days-input" 
        value="{{ $task->no_of_days }}" 
        id="no_of_days-{{ $task->id }}"
        data-task-id="{{ $task->id }}" 
    />
</td>
                        <td class="p-2">{{ $task->task_title }}</td>
                        <td class="p-2">{{ $task->description }}</td>
                        <td class="p-2">{{ $task->employee->email_id ?? 'Not Assigned' }}</td>
                        <td class="p-2">
                            @if (Auth::guard('admin')->check() && $task->status !== 'Completed')
                                <select class="p-1 text-white rounded status-select" data-task-id="{{ $task->id }}">
                                    <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Started" {{ $task->status == 'Started' ? 'selected' : '' }}>Started</option>
                                    <option value="Review" {{ $task->status == 'Review' ? 'selected' : '' }}>Review</option>
                                    <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            @elseif (Auth::guard('employee')->check() && $task->status !== 'Completed')
                                <select class="p-1 text-white rounded status-select" data-task-id="{{ $task->id }}">
                                    <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Started" {{ $task->status == 'Started' ? 'selected' : '' }}>Started</option>
                                    <option value="Review" {{ $task->status == 'Review' ? 'selected' : '' }}>Review</option>
                                    <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            @else
                                <span>{{ $task->status }}</span>
                            @endif
                        </td>
                     

<td class=" text-white">
    {{ $task->redo_count ?? 0 }}
</td>

                        <td class="p-2">{{ $task->task_create_date }}</td>
                                        <td class="p-2">
    <input 
        type="date" 
        class="w-full p-1 rounded text-white task-start-date" 
        value="{{ $task->task_start_date }}" 
        data-task-id="{{ $task->id }}"
        @if(Auth::guard('employee')->check() && $task->task_start_date) disabled @endif
    />
</td>

                        <td class="p-2">
                            <input type="number" class="w-full p-1 rounded text-white no-of-days-input" value="{{ $task->no_of_days }}" data-task-id="{{ $task->id }}" />
                        </td>
                                           <td class="p-2">
    <input 
        type="date" 
        readonly 
        class="w-full p-1 rounded text-white bg-gray-700 task-deadline" 
        value="{{ $task->deadline }}" 
        id="deadline-{{ $task->id }}"
        data-task-id="{{ $task->id }}" 
    />
</td>
                        <td class="p-2">
                            <textarea class="w-full p-1 rounded text-white remark-input" data-task-id="{{ $task->id }}">{{ $task->remarks }}</textarea>
                            <button class="px-2 py-1 bg-blue-600 text-white rounded mt-2 save-remark-btn" data-task-id="{{ $task->id }}">Save</button>
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
<script>
$(document).ready(function () {
    // Update task status
    $(".status-select").change(function () {
        let taskId = $(this).data("task-id");
        let newStatus = $(this).val();

        $.ajax({
            url: "/employee/task/update-status/" + taskId,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                status: newStatus
            },
            success: function (response) {
               if(response.success)
               {
                alert("Update successfully");
               }
               
            },
            error: function (xhr) {
                alert("Error updating status. Check console.");
                console.error(xhr.responseText);
            }
        });
    });

    // Update task start date
    $(".task-start-date").change(function () {
        let taskId = $(this).data("task-id");
        let startDate = $(this).val();

        $.ajax({
            url: "/employee/task/update-start-date/" + taskId,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                task_start_date: startDate
            },
            success: function (response) {
                alert(response.message);
            },
            error: function (xhr) {
                alert("Error updating start date.");
                console.error(xhr.responseText);
            }
        });
    });

    // Delete task
    $(".delete-task-btn").click(function () {
        let taskId = $(this).closest(".task-delete-form").data("task-id");

        if (!confirm("Are you sure you want to delete this task?")) return;

        $.ajax({
            url: "/employee/task/delete/" + taskId,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                _method: "DELETE"
            },
            success: function (response) {
                alert(response.message);
                location.reload();
            },
            error: function (xhr) {
                alert("Error deleting task.");
                console.error(xhr.responseText);
            }
        });
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
        var statusSelect = $("#status-" + taskId); // Dropdown
        var statusText = $("#status-text-" + taskId); // Admin text
        var scoreSpan = $("#score-" + taskId); // Score display

        $.ajax({
            url: "{{ route('tasks.redo') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                task_id: taskId
            },
            success: function (response) {
                redoCountCell.text(response.redo_count);
                scoreSpan.text(response.score);

                // Update status in UI
                if (statusSelect.length) {
                    statusSelect.val(response.status);
                } else {
                    statusText.text(response.status);
                }

                // Optional: Show redo button again if status is not Completed
                if (response.status !== 'Completed') {
                    button.show();
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
//overdue 
$(document).ready(function () {
    $('.task-deadline').each(function () {
        let deadline = new Date($(this).data('deadline'));
        let today = new Date();

        if (deadline < today) {
            $(this).closest('tr').addClass('bg-red-100 text-red-800');
        }
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
</script>
@endsection
