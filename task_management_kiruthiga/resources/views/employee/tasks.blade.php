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
                            <select class="p-1 text-black rounded status-select" data-task-id="{{ $task->id }}">
                                <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Started" {{ $task->status == 'Started' ? 'selected' : '' }}>Started</option>
                                <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Review" {{ $task->status == 'Review' ? 'selected' : '' }}>Review</option>
                            </select>
                        </td>
                        <td class="border border-gray-600 p-2">{{ $task->task_create_date }}</td>
                        <td class="border border-gray-600 p-2">
                            <input type="date" name="task_start_date" id="task_start_date-{{ $task->id }}" value="{{ $task->task_start_date }}" class="w-full p-1 rounded text-black task-start-date" data-task-id="{{ $task->id }}" />
                        </td>
                        <td class="border border-gray-600 p-2">{{ $task->no_of_days }}</td>
                        <td class="border border-gray-600 p-2">
                            <input type="date" name="deadline" id="deadline-{{ $task->id }}" value="{{ $task->deadline }}" readonly class="w-full p-1 rounded text-black bg-gray-700 task-deadline" data-task-id="{{ $task->id }}" />
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
                alert(response.message);
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

</script>
@endsection
