<!-- resources/views/employee/task.blade.php -->

<h2 class="text-xl">My Tasks</h2>

@if($tasks->isEmpty())
    <p>No tasks assigned yet.</p>
@else
    <ul>
        @foreach($tasks as $task)
            <li>
                <strong>Task Title:</strong> {{ $task->task_title }}<br>
                <strong>Assigned To:</strong> {{ $task->employee->name }}<br>
                <strong>Department:</strong> {{ $task->department->name }}<br>
                <strong>Role:</strong> {{ $task->role->name }}<br>
                <strong>Status:</strong> {{ $task->status }}<br>
                <strong>Score:</strong> 
                @if($task->score)
                    {{ $task->score->value }} <!-- Assuming 'value' is the column storing score -->
                @else
                    No score assigned yet.
                @endif
            </li>
        @endforeach
    </ul>
@endif
