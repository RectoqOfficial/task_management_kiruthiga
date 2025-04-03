{{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full p-4">
    <!-- My Tasks Count Card -->
    <div class="bg-gray-800 p-6 rounded-lg shadow-md text-center">
        <h3 class="text-xl font-bold text-white">My Tasks</h3>
        <p id="taskCount" class="text-3xl font-semibold text-red-400 mt-2">0</p>
    </div>

    <!-- Tasks in Progress Count Card -->
    <div class="bg-gray-800 p-6 rounded-lg shadow-md text-center">
        <h3 class="text-xl font-bold text-white">Tasks In Progress</h3>
        <p id="progressTaskCount" class="text-3xl font-semibold text-yellow-400 mt-2">0</p>
    </div>

    <!-- My Score Card -->
    <div class="bg-gray-800 p-6 rounded-lg shadow-md text-center">
        <h3 class="text-xl font-bold text-white">My Score</h3>
        <p id="taskScore" class="text-3xl font-semibold text-green-400 mt-2">0</p>
    </div>
</div>
<script>
    $(document).ready(function () {
        $.ajax({
            url: "/employee/task-stats",
            type: "GET",
            success: function (response) {
                $("#taskCount").text(response.taskCount);
                $("#progressTaskCount").text(response.progressTaskCount);
                $("#taskScore").text(response.taskScore);
            },
            error: function (xhr) {
                console.error("Error fetching task stats:", xhr.responseText);
            }
        });
    });
</script>
  @include('employee.dashboard_cards') --}}