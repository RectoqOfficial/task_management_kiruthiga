<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoreboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-black text-white p-6">

    <div class="max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-center">Scoreboard</h1>

        <div class="p-4 rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Score List</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-center">
                    <thead>
                        <tr class="bg-[#ff0003] text-white font-bold">
                            <th class="p-2 min-w-[80px] whitespace-nowrap">ID</th>
                            <th class="p-2 min-w-[200px] whitespace-nowrap">Task Title</th>
                            <th class="p-2 min-w-[180px] whitespace-nowrap">Task Member</th>
                            <th class="p-2 min-w-[140px] whitespace-nowrap">Status</th>
                            <th class="p-2 min-w-[150px] whitespace-nowrap">Overdue Count</th>
                            <th class="p-2 min-w-[150px] whitespace-nowrap">Redo Count</th>
                            <th class="p-2 min-w-[100px] whitespace-nowrap">Score</th>
                        </tr>
                    </thead>

                    <tbody>
                       @foreach ($tasks as $task)
    <tr class="bg-gray-900 hover:bg-gray-700">
        <td class="p-2">{{ $task->id }}</td>
        <td class="p-2">{{ $task->task_title }}</td>
      <td class="p-2">{{ $task->employee ? $task->employee->email_id : 'No employee assigned' }}</td>

        <td class="p-2">{{ $task->status }}</td>
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

        <td class="p-2">{{ $task->redo_count ?? 0 }}</td>
        <td class="p-2" id="score-{{ $task->id }}">
            {{$task->score ?? 0 }}
        </td>
    </tr>
@endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script>
// Redo count update on button click
$(document).ready(function () {
    $(".redo-btn").click(function () {
        var taskId = $(this).data("task-id");
        var button = $(this);
        var redoCountCell = button.closest("td").find("span.redo-count");
        var scoreCell = $("#score-" + taskId); // This is where the score will be updated

        $.ajax({
            url: "tasks/redo",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                task_id: taskId
            },
            success: function (response) {
                // Update the redo count
                redoCountCell.text(response.redo_count);
                // Update the score
                scoreCell.text(response.score); // Updated score can be negative or positive

                // Dynamically update status to 'Pending'
                var statusSelect = $("#status-" + taskId);
                var statusText = $("#status-text-" + taskId);

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

// Hide redo button when status changes to 'Completed'
$(document).ready(function() {
    $('.status-select').on('change', function() {
        let taskId = $(this).data('task-id');
        let newStatus = $(this).val();

        // If the new status is 'Completed', hide the redo button
        if (newStatus === 'Completed') {
            $('.redo-btn[data-task-id="' + taskId + '"]').hide();
        } else {
            $('.redo-btn[data-task-id="' + taskId + '"]').show();
        }
    });
});
</script>
</body>
</html>
