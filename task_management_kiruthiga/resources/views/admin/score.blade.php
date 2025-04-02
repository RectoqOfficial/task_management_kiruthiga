<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoreboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white p-6">

    <div class="max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-center">Scoreboard</h1>

        <div class="bg-gray-800 p-4 rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Score List</h2>
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-600 text-center">
                    <thead>
                        <tr class="bg-[#ff0003] text-white">
                            <th class="border border-gray-600 p-2">ID</th>
                            <th class="border border-gray-600 p-2">Task Title</th>
                              <th class="border border-gray-600 p-2">Task Member</th>
                            <th class="border border-gray-600 p-2">Status</th>
                            <th class="border border-gray-600 p-2">Overdue Count</th>
                            <th class="border border-gray-600 p-2">Redo Count</th>
                            <th class="border border-gray-600 p-2">Score</th>
                        </tr>
                    </thead>
    <tbody>
    @foreach ($tasks as $task)
        <tr class="bg-gray-900 hover:bg-gray-700">
            <td class="border border-gray-600 p-2">{{ $task->id }}</td>
            <td class="border border-gray-600 p-2">{{ $task->task_title }}</td>
            <td class="border border-gray-600 p-2">{{ $task->assigned_to}}</td>
            <td class="border border-gray-600 p-2">{{ $task->status }}</td>
            <td class="border border-gray-600 p-2">{{ $task->score->overdue_count ?? 0 }}</td>
            <td class="border border-gray-600 p-2">{{ $task->score->redo_count ?? 0 }}</td>
            <td class="border border-gray-600 p-2 font-bold">{{ $task->score->score ?? 0 }}</td>
         
        </tr>
    @endforeach
</tbody>


                </table>
            </div>
        </div>

    </div>

</body>
</html>
