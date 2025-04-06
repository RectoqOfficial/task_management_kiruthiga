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

        <div class="bg-gray-800 p-4 rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Score List</h2>
            <div class="overflow-x-auto">
                <table class="w-full  text-center">
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
            <td class=" p-2">{{ $task->task_title }}</td>
            <td class="p-2">{{ $task->assigned_to}}</td>
            <td class=" p-2">{{ $task->status }}</td>
<td class=" p-2">
    <span class="redo-count" id="redo-{{ $task->id }}">
        {{ $task->redo_count ?? 0 }}
    </span>
</td>

            <td class=" p-2">{{ $task->redo_count ?? 0 }}</td>
<td class=" p-2 font-bold" id="score-{{ $task->id }}">
    {{ $task->score->score ?? 0 }}
</td>
         
        </tr>
    @endforeach
</tbody>
                </table>
            </div>
        </div>

    </div>
<script>
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
    scoreSpan.text(response.score); // Can now show negative values
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

public function updateOverdueTasks()
{
    $tasks = Task::with('score')
        ->where('deadline', '<', now())
        ->where('status', '!=', 'Completed')
        ->get();

    foreach ($tasks as $task) {
        if ($task->score) {
            $task->score->overdue_count += 1;
            $task->score->score -= 5; // or -10 as you need
            $task->score->save();
        }

        // Optional: If overdue_count crosses some threshold
        if ($task->score->overdue_count >= $task->no_of_days) {
            $task->status = "Completed";
            $task->save();
        }
    }

    \Log::info("Overdue tasks updated and score decreased.");
}


</script>
</body>
</html>
