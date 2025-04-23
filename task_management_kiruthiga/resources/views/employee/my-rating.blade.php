@extends('layouts.app')

@section('content')
    <div class="p-6 bg-white rounded shadow">
        <h2 class="text-xl font-bold text-gray-700">Welcome to My Rating Page</h2>

        <table class="min-w-full table-auto border">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="px-4 py-2 border">Task Title</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Score</th>
                    <th class="px-4 py-2 border">Rating</th>  <!-- Added column for ratings -->
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td class="px-4 py-2 border text-black">{{ $task->task_title }}</td>
                        <td class="px-4 py-2 border text-black">{{ $task->status }}</td>
                        <td class="px-4 py-2 border text-black">{{ $task->score }}</td>
                        <td class="px-4 py-2 border text-black">
                            @if($task->rating)
                                {{ $task->rating }} Star{{ $task->rating > 1 ? 's' : '' }} <!-- Display rating -->
                            @else
                                No Rating Yet
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
