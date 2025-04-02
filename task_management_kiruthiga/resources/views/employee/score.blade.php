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
                            <td class="border border-gray-600 p-2">{{ $task->score->redo_count ?? 0 }}</td>
                            <td class="border border-gray-600 p-2 font-bold">{{ $task->score->score ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
