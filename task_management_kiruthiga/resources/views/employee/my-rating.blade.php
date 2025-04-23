@extends('layouts.app')

@section('content')
    <div class="p-6 bg-white rounded shadow">
        <h2 class="text-xl font-bold text-gray-700">Welcome to My Rating Page</h2>

        <table class="min-w-full table-auto border">
            <thead>
                <tr class="bg-red-600 text-white">
                     <th class="px-4 py-2">Id</th>
                    <th class="px-4 py-2">Task Title</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Score</th>
                    <th class="px-4 py-2">Rating</th>  <!-- Added column for ratings -->
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr class=" bg-gray-800 hover:bg-gray-700 text-white">
                      <td class="p-2 ">{{ $task->id }}</td>
                        <td class="p-2  ">{{ $task->task_title }}</td>
                        <td class="p-2  ">{{ $task->status }}</td>
                        <td class="p-2  ">{{ $task->score }}</td>
                        <td class="p-2 ">
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
