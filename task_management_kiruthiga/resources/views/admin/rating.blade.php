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
<form action="{{ route('admin.employee-rating.update', ['taskId' => $task->id]) }}" method="POST" id="rating-form-{{ $task->id }}">
    @csrf
    <select name="rating" class="border rounded px-2 py-1" id="rating-select-{{ $task->id }}">
        <option value="">Select</option>
        @for($i = 1; $i <= 5; $i++)
            <option value="{{ $i }}" {{ $task->rating == $i ? 'selected' : '' }}>
                {{ $i }} Star{{ $i > 1 ? 's' : '' }}
            </option>
        @endfor
    </select>
    <button type="button" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600" onclick="submitRating({{ $task->id }})">Submit</button>
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
    function submitRating(taskId) {
        // Get the selected rating value
        var rating = $('#rating-select-' + taskId).val();

        if (rating === "") {
            alert("Please select a rating.");
            return;
        }

        // Prepare the data to be sent via AJAX
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            rating: rating
        };

        // Send the AJAX request to the server
        $.ajax({
            url: '{{ route('admin.employee-rating.update', ['taskId' => '__taskId__']) }}'.replace('__taskId__', taskId),
            method: 'POST',
            data: data,
            success: function(response) {
                // If the request was successful, update the rating on the page
                alert('Rating updated successfully!');
                // Optionally, you can also update the rating in the table directly here
                // $('#rating-column-' + taskId).text(rating + ' Star(s)');
            },
            error: function(xhr, status, error) {
                // Handle errors here
                alert('There was an error updating the rating.');
            }
        });
    }
</script>


