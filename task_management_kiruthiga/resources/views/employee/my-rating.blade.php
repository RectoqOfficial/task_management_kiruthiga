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
        <div class="flex text-yellow-500">
            @for ($i = 1; $i <= 5; $i++)
                @if ($i <= $task->rating)
                    <svg class="w-5 h-5 fill-current text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09L5.5 12.18.622 7.91l6.254-.91L10 1l3.124 6.001 6.254.91-4.878 4.27 1.378 5.91z"/>
                    </svg>
                @else
                    <svg class="w-5 h-5 fill-current text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09L5.5 12.18.622 7.91l6.254-.91L10 1l3.124 6.001 6.254.91-4.878 4.27 1.378 5.91z"/>
                    </svg>
                @endif
            @endfor
        </div>
    @else
        <span class="text-gray-500">No Rating Yet</span>
    @endif
</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
