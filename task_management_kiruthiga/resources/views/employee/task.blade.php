<!-- resources/views/employee/tasks.blade.php -->

<h2 class="text-xl font-bold mb-4">My Tasks</h2>

@if($tasks->isEmpty())
    <p>No tasks assigned to you yet.</p>
@else
   <div class="overflow-x-auto">
    <table class="w-full border border-gray-600 text-center">
        <thead>
            <tr class="bg-[#ff0003] text-white">
                <th class="border border-gray-600 p-2">ID</th>
                <th class="border border-gray-600 p-2">Task Title</th>
                <th class="border border-gray-600 p-2">Description</th>
                <th class="border border-gray-600 p-2">Status</th>
                <th class="border border-gray-600 p-2">Task Create Date</th>
                <th class="border border-gray-600 p-2">Task Start Date</th>
                <th class="border border-gray-600 p-2">No. of Days</th>
                <th class="border border-gray-600 p-2">Deadline</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr class="bg-gray-900 hover:bg-gray-700">
                    <td class="border border-gray-600 p-2">{{ $task->id }}</td>
                    <td class="border border-gray-600 p-2">{{ $task->task_title }}</td>
                    <td class="border border-gray-600 p-2">{{ $task->description }}</td>
                    
                    <!-- Status Column with Dropdown -->
                    <td class="border border-gray-600 p-2">
                        <select class="p-1 text-black rounded status-select" data-task-id="{{ $task->id }}">
                            <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Started" {{ $task->status == 'Started' ? 'selected' : '' }}>Started</option>
                            <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Review" {{ $task->status == 'Review' ? 'selected' : '' }}>Review</option>
                        </select>
                    </td>

                    <td class="border border-gray-600 p-2">{{ $task->task_create_date }}</td>
                    
                    <!-- Task Start Date (Editable) -->
                    <td class="border border-gray-600 p-2">
                        <input type="date" name="task_start_date" id="task_start_date-{{ $task->id }}" value="{{ $task->task_start_date }}" class="w-full p-1 rounded text-black task-start-date" data-task-id="{{ $task->id }}" />
                    </td>

                    <!-- Number of Days (If needed) -->
                    <td class="border border-gray-600 p-2">{{ $task->no_of_days }}</td>

                    <!-- Calculate Deadline Based on Task Start Date -->
                    <td class="border border-gray-600 p-2">
                        <input type="date" name="deadline" id="deadline-{{ $task->id }}" value="{{ $task->deadline }}" readonly class="w-full p-1 rounded text-black bg-gray-700 task-deadline" data-task-id="{{ $task->id }}" />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endif
