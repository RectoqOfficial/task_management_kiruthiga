@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold text-white mb-4">My Tasks</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-600 text-center">
            <thead>
                <tr class="bg-[#ff0003] text-white">
                    <th class="border border-gray-600 p-2">ID</th>
                    <th class="border border-gray-600 p-2">Task Title</th>
                    <th class="border border-gray-600 p-2">Description</th>
                   
                    <th class="border border-gray-600 p-2">Status</th>
                     <th class="border border-gray-600 p-2">Redo Count</th>
                    <th class="border border-gray-600 p-2">Task Create Date</th>
                    <th class="border border-gray-600 p-2">Task Start Date</th>
                    <th class="border border-gray-600 p-2">No. of Days</th>
                    <th class="border border-gray-600 p-2">Deadline</th>
                     <th class="border border-gray-600 p-2">Remarks</th>
      
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr class="bg-gray-900 hover:bg-gray-700">
                        <td class="border border-gray-600 p-2">{{ $task->id }}</td>
                        <td class="border border-gray-600 p-2">{{ $task->task_title }}</td>
                        <td class="border border-gray-600 p-2">{{ $task->description }}</td>

  
<td class="border border-gray-600 p-2">
    
    {{-- Admin Dropdown --}}
    @if (Auth::guard('admin')->check() && $task->status !== 'Completed')
        <select id="status-{{ $task->id }}" class="p-1 text-black rounded status-select" data-task-id="{{ $task->id }}">
              <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                          <option value="Started" {{ $task->status == 'Started' ? 'selected' : '' }}>Started</option>
                                      <option value="Review" {{ $task->status == 'Review' ? 'selected' : '' }}>Review</option>
        </select>

    {{-- Employee Dropdown --}}
    @elseif (Auth::guard('employee')->check() && $task->status !== 'Completed')
        <select id="status-{{ $task->id }}" class="p-1 text-black rounded status-select" data-task-id="{{ $task->id }}">
   
              <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                          <option value="Started" {{ $task->status == 'Started' ? 'selected' : '' }}>Started</option>
                                      <option value="Review" {{ $task->status == 'Review' ? 'selected' : '' }}>Review</option>
        </select>

    {{-- Read-Only Text for Everyone Else --}}
    @else
        <span id="status-text-{{ $task->id }}">{{ $task->status }}</span>
    @endif
</td>




<td class="border border-gray-600 p-2 text-white">
    {{ $task->redo_count ?? 0 }}
</td>


                        <td class="border border-gray-600 p-2 text-white">{{ $task->task_create_date }}</td>
                        <td class="border border-gray-600 p-2">
                            <input type="date" name="task_start_date" id="task_start_date-{{ $task->id }}" value="{{ $task->task_start_date }}" class="w-full p-1 rounded text-white task-start-date" data-task-id="{{ $task->id }}" />
                        </td>
                        <td class="border border-gray-600 p-2 text-white">{{ $task->no_of_days }}</td>
                        <td class="border border-gray-600 p-2">
                            <input type="date" name="deadline" id="deadline-{{ $task->id }}" value="{{ $task->deadline }}" readonly class="w-full p-1 rounded text-white bg-gray-700 task-deadline" data-task-id="{{ $task->id }}" />
                        </td>
 <td class="border border-gray-600 p-2">
    <textarea class="w-full p-1 rounded text-white remark-input" data-task-id="{{ $task->id }}">{{ $task->remarks }}</textarea>
    <button class="px-2 py-1 bg-blue-600 text-white rounded mt-2 save-remark-btn" data-task-id="{{ $task->id }}">
        Save
    </button>
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
</script>
@endsection
