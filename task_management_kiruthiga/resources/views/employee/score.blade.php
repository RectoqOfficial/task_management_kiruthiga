<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Score</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4 text-center">My Scores</h1>
        <div class="overflow-x-auto">
            <table class="w-full  text-center">
                  <thead>
    <tr class="bg-[#ff0003] text-white font-bold">
        <th class="p-2 min-w-[80px] whitespace-nowrap">ID</th>
        <th class="p-2 min-w-[200px] whitespace-nowrap">Task Title</th>
       
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
              
            <td class=" p-2">{{ $task->status }}</td>
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


            <td class=" p-2">{{ $task->redo_count ?? 0 }}</td>
<td class=" p-2  ">
    {{ $task->score ?? 0 }}
</td>
         
        </tr>
    @endforeach
</tbody>
            </table>
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

</script>
</body>
</html>
