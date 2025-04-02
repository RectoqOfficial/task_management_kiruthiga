@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold text-white">My Tasks</h2>

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
                        <td class="border border-gray-600 p-2">{{ $task->status }}</td>
                        <td class="border border-gray-600 p-2">{{ $task->task_create_date }}</td>
                        <td class="border border-gray-600 p-2">{{ $task->task_start_date }}</td>
                        <td class="border border-gray-600 p-2">{{ $task->no_of_days }}</td>
                        <td class="border border-gray-600 p-2">{{ $task->deadline }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
