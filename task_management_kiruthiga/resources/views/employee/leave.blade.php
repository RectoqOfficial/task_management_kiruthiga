<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">

    <div class="container mx-auto px-4 py-6 max-w-4xl">
        <h1 class="text-2xl font-bold mb-4">My Leave Requests</h1>

        <!-- Message -->
        <div id="message" class="hidden mb-4 px-4 py-2 rounded text-white font-medium"></div>

        <!-- Apply for Leave Form -->
        <div class="mb-6 bg-gray-800 p-4 rounded shadow">
            <h2 class="text-xl font-semibold mb-4">Apply for Leave</h2>
            <form id="leaveForm">
                @csrf
                <div class="mb-4">
                    <label for="leave_type_id" class="block text-sm font-semibold text-white">Leave Type</label>
                    <select name="leave_type_id" id="leave_type_id" class="mt-1 block w-full text-black bg-white border border-gray-300 rounded p-2">
                        @foreach($leaveTypes as $leaveType)
                            <option value="{{ $leaveType->id }}">{{ ucfirst($leaveType->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="start_date" class="block text-sm font-semibold text-white">Leave Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="mt-1 block w-full border border-gray-300 rounded p-2 text-black" required>
                </div>

                <div class="mb-4">
                    <label for="end_date" class="block text-sm font-semibold text-white">Leave End Date</label>
                    <input type="date" name="end_date" id="end_date" class="mt-1 block w-full border border-gray-300 rounded p-2 text-black" required>
                </div>

                <div class="mb-4">
                    <label for="notes" class="block text-sm font-semibold text-white">Reason for Leave</label>
                    <textarea name="notes" id="notes" class="mt-1 block w-full border border-gray-300 rounded p-2 text-black" rows="4"></textarea>
                </div>

                <button type="submit" class="w-full py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 transition duration-200">
                    Submit Request
                </button>
            </form>
        </div>

        <!-- Leave Requests Table -->
        <h2 class="text-xl font-semibold mb-2">My Leave History</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse border border-gray-300">
                <thead class="bg-gray-200">
                    <tr class="bg-[#ff0003] text-white">
                        <th class="px-4 py-2 text-left">Leave Type</th>
                        <th class="px-4 py-2 text-left">Leave Dates</th>
                        <th class="px-4 py-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody id="leaveTable">
                    @foreach($leaveRequests as $leave)
                        <tr>
                            <td class="px-4 py-2">{{ ucfirst($leave->leaveType->name) }}</td>
                            <td class="px-4 py-2">{{ $leave->start_date }} to {{ $leave->end_date }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-white rounded 
                                    {{ $leave->status == 'Approved' ? 'bg-green-500' : ($leave->status == 'Rejected' ? 'bg-red-500' : 'bg-yellow-500') }}">
                                    {{ $leave->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Leave Balance -->
 <div class="mt-6 bg-gray-500 p-4 rounded shadow text-white">
    <h2 class="text-xl font-semibold mb-2">My Leave Balance</h2>
    <p>Vacation Leave: <strong>{{ $vacationLeaveBalance }}</strong> days</p>
    <p>Sick Leave: <strong>{{ $sickLeaveBalance }}</strong> days</p>
    <p>Casual Leave: <strong>{{ $casualLeaveBalance }}</strong> days</p>
</div>



    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#leaveForm').submit(function(e) {
            e.preventDefault();

            let formData = {
                leave_type_id: $('#leave_type_id').val(),
                start_date: $('#start_date').val(),
                end_date: $('#end_date').val(),
                notes: $('#notes').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: "{{ route('employee.leave.store') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    $('#message')
                        .removeClass('hidden bg-red-500')
                        .addClass('bg-green-500')
                        .text(response.message)
                        .fadeIn().delay(3000).fadeOut();

                    $('#leaveForm')[0].reset();

                    // Optional: Append new leave to table
                    $('#leaveTable').append(`
                        <tr>
                            <td class="px-4 py-2">${response.leave_type}</td>
                            <td class="px-4 py-2">${response.start_date} to ${response.end_date}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-white rounded bg-yellow-500">Pending</span>
                            </td>
                        </tr>
                    `);
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let msg = Object.values(errors).join(', ');
                    $('#message')
                        .removeClass('hidden bg-green-500')
                        .addClass('bg-red-500')
                        .text(msg)
                        .fadeIn().delay(5000).fadeOut();
                }
            });
        });

        
    </script>
</body>
</html>
