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
        <h1 class="text-2xl font-bold mb-4 text-center">Employee Task Scores</h1>
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-600 text-center text-sm md:text-base">
                <thead>
                    <tr class="bg-[#ff0003] text-white">
                        <th class="border border-gray-600 p-2">ID</th>
                        <th class="border border-gray-600 p-2">Task Title</th>
                        <th class="border border-gray-600 p-2">Status</th>
                        <th class="border border-gray-600 p-2">Overdue Count</th>
                        <th class="border border-gray-600 p-2">Redo Count</th>
                        <th class="border border-gray-600 p-2">Score</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr class="bg-gray-900 hover:bg-gray-700 text-white">
                            <td class="border border-gray-600 p-2">{{ $task->id }}</td>
                            <td class="border border-gray-600 p-2">{{ $task->task_title }}</td>
                            <td class="border border-gray-600 p-2">{{ $task->status }}</td>
                            <td class="border border-gray-600 p-2">{{ $task->score->overdue_count ?? 0 }}</td>
                            <td class="border border-gray-600 p-2">{{ $task->redo_count ?? 0 }}</td>
<td class="border border-gray-600 p-2 font-bold" id="score-{{ $task->id }}">
    {{ $task->score->score ?? 0 }}
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
