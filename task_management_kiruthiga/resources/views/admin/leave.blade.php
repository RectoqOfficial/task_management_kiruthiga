<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Leave Requests</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-900">

<div class="container mx-auto p-4 max-w-screen-lg">
    <h1 class="text-2xl font-bold mb-4">Employee Leave Requests</h1>



    <!-- Alert Message -->
    <div id="alertBox" class="hidden mb-4 px-4 py-2 rounded text-white"></div>

    <!-- Leave Requests Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse border border-gray-300">
            <thead class="">
            <tr class="bg-red-600 text-white">
                      
                <th class="p-2">ID</th>
                <th class="p-2">Employee Name</th>
                <th class="p-2">Leave Type</th>
                <th class="p-2">Leave Dates</th>
                <th class="p-2">Status</th>
                <th class="p-2">Actions</th>
            </tr>
            </thead>
            <tbody id="contentArea">
            @foreach($leaveRequests as $leave)
                <tr id="row-{{ $leave->id }}" class="bg-gray-800 hover:bg-gray-700 text-white">
                    <td class="p-2">{{ $leave->employee->id }}</td>
                    <td class="p-2">{{ $leave->employee->full_name }}</td>
                    <td class="p-2">{{ ucfirst($leave->leaveType->name) }}</td>
                    <td class="p-2">{{ $leave->start_date }} to {{ $leave->end_date }}</td>
                    <td class="p-2">
                        <span id="status-{{ $leave->id }}"
                              class="badge {{ $leave->status == 'Approved' ? 'bg-green-500' : ($leave->status == 'Rejected' ? 'bg-red-500' : 'bg-yellow-500') }} text-white px-2 py-1 rounded">
                            {{ $leave->status }}
                        </span>
                    </td>
                  <td class="p-2">
    <div class="flex flex-col sm:flex-row sm:flex-wrap gap-2">
        <button onclick="handleApprove({{ $leave->id }})"
                class="bg-green-500 text-white px-4 py-2 rounded w-full sm:w-auto">Approve</button>
        <button onclick="handleReject({{ $leave->id }})"
                class="bg-red-500 text-white px-4 py-2 rounded w-full sm:w-auto">Reject</button>
        <button onclick="viewDetails({{ $leave->id }})"
                class="bg-blue-500 text-white px-4 py-2 rounded w-full sm:w-auto">View Details</button>
    </div>
</td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $leaveRequests->links() }}
    </div>
</div>

<!-- View Details Modal -->
<div id="detailsModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-black rounded-lg shadow-lg p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Leave Details</h2>
            <button onclick="closeModal()" class="text-red-500 font-bold text-lg">X</button>
        </div>
        <div id="modalContent" class="text-sm space-y-2">
            <!-- Populated by JS -->
        </div>
    </div>
</div>

<script>
    function showAlert(message, type = 'success') {
        $('#alertBox')
            .removeClass()
            .addClass('mb-4 px-4 py-2 rounded text-white')
            .addClass(type === 'success' ? 'bg-green-500' : 'bg-red-500')
            .text(message)
            .fadeIn()
            .delay(2000)
            .fadeOut();
    }

    function handleApprove(id) {
        $.ajax({
            url: '/admin/leave/approve/' + id,
            type: 'GET',
            success: function () {
                $('#status-' + id).removeClass().addClass('bg-green-500 text-white px-2 py-1 rounded').text('Approved');
                showAlert('Leave approved successfully.');
            }
        });
    }

    function handleReject(id) {
        $.ajax({
            url: '/admin/leave/reject/' + id,
            type: 'GET',
            success: function () {
                $('#status-' + id).removeClass().addClass('bg-red-500 text-white px-2 py-1 rounded').text('Rejected');
                showAlert('Leave rejected successfully.');
            }
        });
    }

    function viewDetails(id) {
        $.ajax({
            url: '/admin/leave/view/' + id,
            type: 'GET',
            success: function (response) {
                const leave = response.leave;
                $('#modalContent').html(`
                    <p><strong>Employee:</strong> ${leave.employee.full_name}</p>
                    <p><strong>Leave Type:</strong> ${leave.leave_type}</p>
                    <p><strong>Start Date:</strong> ${leave.start_date}</p>
                    <p><strong>End Date:</strong> ${leave.end_date}</p>
                    <p><strong>Reason:</strong> ${leave.reason}</p>
                    <p><strong>Status:</strong> ${leave.status}</p>
                `);
                $('#detailsModal').removeClass('hidden');
            }
        });
    }

    function closeModal() {
        $('#detailsModal').addClass('hidden');
    }





</script>

</body>
</html>
