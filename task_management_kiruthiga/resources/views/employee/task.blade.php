@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold text-white">My Tasks</h2>
    <table class="table-auto w-full mt-4 text-white">
        <thead>
            <tr>
                <th class="px-4 py-2">Task Name</th>
                <th class="px-4 py-2">Deadline</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
            <tr>
                <td class="border px-4 py-2">{{ $task->name }}</td>
                <td class="border px-4 py-2">{{ $task->deadline }}</td>
                <td class="border px-4 py-2">{{ $task->status }}</td>
                <td class="border px-4 py-2">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded view-task-btn" data-id="{{ $task->id }}">
                        View
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Task Details Modal -->
    <div id="taskModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex justify-center items-center">
        <div class="bg-black p-6 rounded-lg shadow-lg w-1/2">
            <h3 id="taskTitle" class="text-xl font-bold text-white"></h3>
            <p id="taskDescription" class="text-white mt-2"></p>
            <p id="taskDeadline" class="text-white mt-2"></p>
            <button onclick="closeModal()" class="bg-red-500 text-white px-4 py-2 mt-4 rounded">Close</button>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $(".view-task-btn").click(function(){
        let taskId = $(this).data("id");

        $.ajax({
            url: "/employee/task/" + taskId,
            type: "GET",
            success: function(task) {
                $("#taskTitle").text(task.name);
                $("#taskDescription").text("Description: " + task.description);
                $("#taskDeadline").text("Deadline: " + task.deadline);
                $("#taskModal").removeClass("hidden");
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    });
});

function closeModal() {
    $("#taskModal").addClass("hidden");
}
</script>
@endsection
