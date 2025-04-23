@extends('layouts.app')

@section('content')
    <div class="p-6 bg-white rounded shadow">
        <h2 class="text-xl font-bold text-gray-700">Welcome to Rating Page</h2>
        
        @if(session('success'))
            <div class="mb-4 text-green-600 font-semibold">{{ session('success') }}</div>
        @endif

        <table class="min-w-full table-auto border">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="px-4 py-2 border">Task Title</th>
                    <th class="px-4 py-2 border">Employee</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Completed At</th>
                    <th class="px-4 py-2 border">Score</th>
                    <th class="px-4 py-2 border">Rating</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td class="px-4 py-2 border text-black">{{ $task->task_title }}</td>
                        <td class="px-4 py-2 border text-black">{{ $task->employee->full_name }}</td>
                        <td class="px-4 py-2 border text-black">{{ $task->status }}</td>
                        <td class="px-4 py-2 border text-black">{{ $task->completed_at ?? 'Not Completed Yet' }}</td>
                        <td class="px-4 py-2 border text-black">{{ $task->score }}</td>
<td class="px-4 py-2 border text-black">
    <form id="rating-form-{{ $task->id }}">
        @csrf
        <div class="flex space-x-1 text-yellow-500 cursor-pointer" id="stars-{{ $task->id }}">
            @for($i = 1; $i <= 5; $i++)
                <svg data-value="{{ $i }}" class="star-{{ $task->id }} w-6 h-6 fill-current {{ $task->rating >= $i ? 'text-yellow-400' : 'text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M10 15l-5.878 3.09L5.5 12.18.622 7.91l6.254-.91L10 1l3.124 6.001 6.254.91-4.878 4.27 1.378 5.91z"/>
                </svg>
            @endfor
        </div>

        <input type="hidden" name="rating" id="rating-input-{{ $task->id }}">

        <button type="button" class="mt-2" onclick="submitRating({{ $task->id }})">
            <img src="/build/assets/img/update.png" alt="Update" class="inline w-6 h-6"
             class="w-5 h-5 cursor-pointer"
                     style="filter: invert(48%) sepia(94%) saturate(2977%) hue-rotate(102deg) brightness(93%) contrast(89%);">
        </button>
    </form>
</td>


                          
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        @foreach($tasks as $task)
            let selectedRating{{ $task->id }} = {{ $task->rating ?? 0 }};
            
            $('#stars-{{ $task->id }} .star-{{ $task->id }}').on('mouseover', function () {
                let val = $(this).data('value');
                highlightStars(val, {{ $task->id }});
            }).on('mouseleave', function () {
                highlightStars(selectedRating{{ $task->id }}, {{ $task->id }});
            }).on('click', function () {
                selectedRating{{ $task->id }} = $(this).data('value');
                $('#rating-input-{{ $task->id }}').val(selectedRating{{ $task->id }});
            });

            function highlightStars(val, taskId) {
                $('#stars-' + taskId + ' .star-' + taskId).each(function () {
                    if ($(this).data('value') <= val) {
                        $(this).removeClass('text-gray-300').addClass('text-yellow-400');
                    } else {
                        $(this).removeClass('text-yellow-400').addClass('text-gray-300');
                    }
                });
            }

            // Initial highlight
            highlightStars(selectedRating{{ $task->id }}, {{ $task->id }});
        @endforeach
    });

    function submitRating(taskId) {
        var rating = $('#rating-input-' + taskId).val();
        if (rating === "") {
            alert("Please select a rating.");
            return;
        }

        $.ajax({
            url: '{{ route('admin.employee-rating.update', ['taskId' => '__taskId__']) }}'.replace('__taskId__', taskId),
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                rating: rating
            },
            success: function () {
                alert("Rating updated successfully!");
            },
            error: function () {
                alert("Error updating rating.");
            }
        });
    }
</script>


