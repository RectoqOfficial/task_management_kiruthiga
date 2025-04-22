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

  <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
<meta name="description" content="Task Management Dashboard for assigning, tracking, and managing tasks efficiently.">

</head>
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
                    <th class="p-2 whitespace-nowrap min-w-[100px]">Overdue</th>

                    <th class="p-2 whitespace-nowrap min-w-[100px]">Status</th>
                    <th class="p-2 whitespace-nowrap min-w-[130px]">Redo Count</th>
                    <th class="p-2 whitespace-nowrap min-w-[160px]">Task Create Date</th>
                    <th class="p-2 whitespace-nowrap min-w-[160px]">Task Start Date</th>
                    <th class="p-2 whitespace-nowrap min-w-[130px]">No. of Days</th>
                    <th class="p-2 whitespace-nowrap min-w-[120px]">Deadline</th>
                           <th class="p-2 whitespace-nowrap min-w-[120px]">Task Document</th>
                    <th class="p-2 whitespace-nowrap min-w-[120px]">Flowchart</th>
                    <th class="p-2 whitespace-nowrap min-w-[120px]">Sheet Detail</th>
                    <th class="p-2 whitespace-nowrap min-w-[140px]">Remarks</th>
                    
                </tr>
            </thead>
             <tbody id="task-table-body" class="text-sm">
                @foreach ($tasks as $task)
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
                $overdue = floor($deadline->floatDiffInRealDays($now));
                $overdue = max($overdue, 0);
            }
        }

        // Calculate penalty (-30 per day)
        $penalty = $overdue * -30;
    @endphp

    <span>{{ $overdue }} day(s)</span><br>
    {{-- <span class="text-red-600">Score: {{ $penalty }}</span> --}}
</td>


                        
                        <td class="p-2">
                           @if (Auth::guard('admin')->check() && $task->status !== 'Completed')
    <select class="p-1 text-black bg-white border border-white rounded status-select" data-task-id="{{ $task->id }}">
        <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
        <option value="Started" {{ $task->status == 'Started' ? 'selected' : '' }}>Started</option>
        <option value="Review" {{ $task->status == 'Review' ? 'selected' : '' }}>Review</option>
        <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
    </select>
@elseif (Auth::guard('employee')->check() && $task->status !== 'Completed')
    <select class="p-1 text-black bg-white border border-white rounded status-select" data-task-id="{{ $task->id }}">
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
    class="w-full p-1 rounded text-black bg-white border border-white task-start-date" 
    value="{{ $task->task_start_date }}" 
    data-task-id="{{ $task->id }}"
    @if(Auth::guard('employee')->check() && $task->task_start_date) disabled @endif
/>

</td>

                        <td class="p-2">
<input 
    type="number" 
    class="w-full p-1 rounded text-black bg-white border border-white no-of-days-input" 
    value="{{ $task->no_of_days }}" 
    data-task-id="{{ $task->id }}" 
    @if($task->no_of_days) readonly @endif
/>


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
<!-- Task Document Upload and View -->
<td class="p-2">
    <!-- Upload Form -->
    <form action="{{ route('tasks.uploadDocument', $task->id) }}" method="POST" enctype="multipart/form-data" class="upload-form">
        @csrf
        <input type="file" name="task_document" class="text-white">
        <button type="submit" class="mt-1 bg-blue-600 text-white px-2 py-1 rounded">Upload</button>
    </form>
    
    <!-- Display Uploaded Task Document -->
    <div id="task_document-{{ $task->id }}-view">
        @if($task->task_document)
            <a href="{{ asset('storage/' . $task->task_document) }}" target="_blank" class="text-blue-500">View Task Document</a>
        @else
            <span class="text-red-500">No Document Uploaded</span>
        @endif
    </div>
</td>

<!-- Flowchart Upload and View -->
<td class="p-2">
    <!-- Upload Form -->
    <form action="{{ route('tasks.uploadFlowchart', $task->id) }}" method="POST" enctype="multipart/form-data" class="upload-form">
        @csrf
        <input type="file" name="flowchart" class="text-white">
        <button type="submit" class="mt-1 bg-blue-600 text-white px-2 py-1 rounded">Upload</button>
    </form>
    
    <!-- Display Uploaded Flowchart -->
    <div id="flowchart-{{ $task->id }}-view">
        @if($task->flowchart)
            <a href="{{ asset('storage/' . $task->flowchart) }}" target="_blank" class="text-blue-500">View Flowchart</a>
        @else
            <span class="text-red-500">No Flowchart Uploaded</span>
        @endif
    </div>
</td>

<!-- Sheet Detail Upload and View -->
<td class="p-2">
    <!-- Upload Form -->
    <form action="{{ route('tasks.uploadSheet', $task->id) }}" method="POST" enctype="multipart/form-data" class="upload-form">
        @csrf
        <input type="file" name="sheet_detail" class="text-white">
        <button type="submit" class="mt-1 bg-blue-600 text-white px-2 py-1 rounded">Upload</button>
    </form>
    
    <!-- Display Uploaded Sheet -->
    <div id="sheet_detail-{{ $task->id }}-view">
        @if($task->sheet_detail)
            <a href="{{ asset('storage/' . $task->sheet_detail) }}" target="_blank" class="text-blue-500">View Sheet Detail</a>
        @else
            <span class="text-red-500">No Sheet Uploaded</span>
        @endif
    </div>
</td>


                     <td class="p-2">
                            <textarea class="w-full p-1 rounded text-white remark-input" data-task-id="{{ $task->id }}">{{ $task->remarks }}</textarea>
                            <button class="px-2 py-1 bg-blue-600 text-white rounded mt-2 save-remark-btn" data-task-id="{{ $task->id }}">Save</button>
                        </td>
                       
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
$(document).ready(function () {
    // CSRF token setup for jQuery
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // ✅ Update remarks
    $(".save-remark-btn").click(function () {
        let taskId = $(this).data("task-id");
        let remarks = $(`.remark-input[data-task-id="${taskId}"]`).val();

        $.ajax({
            url: `/tasks/${taskId}/update-remarks`,
            type: 'POST',
            data: { remarks: remarks },
            success: function (response) {
                if (response.success) {
                    alert('Remarks updated successfully!');
                } else {
                    alert('Failed to update remarks.');
                }
            },
            error: function (xhr) {
                alert('Error updating remarks.');
                console.log(xhr.responseText);
            }
        });
    });

    // ✅ Update task status
    $(".status-select").change(function () {
        let taskId = $(this).data("task-id");
        let newStatus = $(this).val();

        $.ajax({
            url: "/employee/task/update-status/" + taskId,
            type: "POST",
            data: {
                status: newStatus
            },
            success: function (response) {
                alert("Status updated successfully!");
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
    });

    // ✅ Update task start date
    $(".task-start-date").change(function () {
        let taskId = $(this).data("task-id");
        let startDate = $(this).val();

        $.ajax({
            url: "/employee/task/update-start-date/" + taskId,
            type: "POST",
            data: {
                task_start_date: startDate
            },
            success: function (response) {
                alert("Start date updated!");
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
    });

    // ✅ Delete task
    $(".delete-task-btn").click(function () {
        if (!confirm("Are you sure you want to delete this task?")) return;

        let taskId = $(this).closest(".task-delete-form").data("task-id");

        $.ajax({
            url: `/employee/task/delete/${taskId}`,
            type: "POST",
            data: {
                _method: "DELETE"
            },
            success: function (response) {
                alert("Task deleted successfully!");
                location.reload();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
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
$(document).ready(function() {
    // Handle the form submission using AJAX
    $('.upload-form').submit(function(e) {
        e.preventDefault(); // Prevent page reload
        
        let form = $(this);
        let formData = new FormData(form[0]);
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Check if upload was successful
                if (response.success) {
                    let fileLink = response.file_url;
                    let fileName = response.file_name; // Assuming your backend sends the file name
                    let fileType = '';
                    let viewLinkHtml = '';
                    
                    // Determine file type (task_document, flowchart, or sheet_detail)
                    if (form.find('input[name="task_document"]').length > 0) {
                        fileType = 'task_document';
                    } else if (form.find('input[name="flowchart"]').length > 0) {
                        fileType = 'flowchart';
                    } else if (form.find('input[name="sheet_detail"]').length > 0) {
                        fileType = 'sheet_detail';
                    }
                    
                    // Construct the view link HTML
                    viewLinkHtml = `<a href="${fileLink}" target="_blank" class="text-blue-500">View ${fileType.replace('_', ' ').toUpperCase()}</a>`;
                    
                    // Update the appropriate view section for the file type
                    $(`#${fileType}-${form.data('task-id')}-view`).html(viewLinkHtml);

                    // Dynamically append a new row in the table
                    let tableRow = `
                        <tr>
                            <td>${form.data('task-id')}</td>
                            <td>${fileName}</td>
                            <td>${viewLinkHtml}</td>
                        </tr>
                    `;
                    
                    // Append the new row to the table with ID 'task-documents-table'
                    $('#task-documents-table tbody').append(tableRow);
                    
                    // Show success alert with the file name
                    alert("Upload successful! File: " + fileName);
                } else {
                    alert("File upload failed");
                }
            },
            error: function() {
                alert("An error occurred while uploading the file.");
            }
        });
    });
});


</script>
@endsection
