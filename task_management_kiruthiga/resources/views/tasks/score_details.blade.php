<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome |score-management </title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-black min-h-screen">
    <h2 class="text-3xl font-bold mb-6 text-center text-white">Scoreboard</h2>

    <div class="overflow-x-auto mt-6">
        <table class="min-w-full table-auto border-collapse bg-black rounded-lg shadow-md">
            <thead>
                <tr class="text-white bg-[#ff0003]">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Task Title</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Redo Count</th>
                    <th class="border px-4 py-2">Overdue</th>
                    <th class="border px-4 py-2">Score</th>
                    <th class="border px-4 py-2">History</th>
                </tr>
            </thead>
            <tbody>
 @foreach($tasks as $task)
<tr class="text-white hover:bg-gray-700 transition duration-300">
    <td class="border px-4 py-2">{{ $task->id }}</td>
    <td class="border px-4 py-2">{{ $task->task_title ?? 'N/A' }}</td>
    <td class="border px-4 py-2">{{ $task->status ?? 'N/A' }}</td>
    <td class="border px-4 py-2">{{ $task->scoreDetails->count() }}</td>
    <td class="border px-4 py-2">
        {{ optional($task->scoreDetails->last())->overdue ? 'Yes' : 'No' }}
    </td>
    <td class="border px-4 py-2">
        {{ optional($task->scoreDetails->last())->score ?? 'N/A' }}
    </td>
    <td class="border px-4 py-2">
        {{ optional($task->scoreDetails->last())->history ?? 'No history available' }}
    </td>
</tr>
@endforeach


            </tbody>
        </table>
    </div>
</div>
@endsection
