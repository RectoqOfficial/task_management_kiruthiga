<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-black flex h-screen">

    <!-- Sidebar -->
    <div id="sidebar" class="w-64 bg-black h-screen p-4 hidden md:block">
        <a class="text-lg font-bold text-white block text-center mb-6" href="#">EMPLOYEE PANEL</a>
        <ul>
            <li class="px-4 py-3">
                <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadDashboard(event)">
                    <span class="icon-container w-5 h-5"></span>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>

            <li class="px-4 py-3">
    <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadMyTasks(event)">
        <span class="icon-container w-5 h-5"></span>
        <span class="ml-4">My Task</span>
    </a>
</li>


            <li class="px-4 py-3">
                <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadMyProfile(event)">
                    <span class="icon-container w-5 h-5"></span>
                    <span class="ml-4">My Profile</span>
                </a>
            </li>

            <li class="px-4 py-3">
                <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadMyScore(event)">
                    <span class="icon-container w-5 h-5"></span>
                    <span class="ml-4">My Score</span>
                </a>
            </li>

            <!-- Logout Button -->
            <li class="px-4 py-3">
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                   class="block text-center text-white bg-[#ff0003] px-4 py-2 rounded-md hover:bg-red-700 
                          transition duration-300 ease-in-out transform hover:scale-105 shadow-md 
                          hover:shadow-red-500/50 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6-8V3m0 18v-2"></path>
                    </svg>
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </li>
        </ul>
    </div>

    <!-- Mobile Sidebar Toggle -->
    <div class="absolute top-4 left-4 md:hidden">
        <button onclick="toggleSidebar()" class="bg-[#ff0003] text-white p-2 rounded-md">
            ☰ Menu
        </button>
    </div>

    <!-- Mobile Sidebar -->
    <div id="mobileSidebar" class="fixed inset-0 bg-black w-64 p-4 transform -translate-x-full transition-transform duration-300 md:hidden">
        <button onclick="toggleSidebar()" class="absolute top-4 right-4 text-white text-2xl">×</button>
        <a class="text-lg font-bold text-white block text-center mb-6" href="#">EMPLOYEE PANEL</a>
        <ul>
            <li class="px-4 py-3">
                <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadDashboard(event)">
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>

            <li class="px-4 py-3">
                <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadMyTasks(event)">
                    <span class="ml-4">My Tasks</span>
                </a>
            </li>

            <li class="px-4 py-3">
                <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadMyProfile(event)">
                    <span class="ml-4">My Profile</span>
                </a>
            </li>

            <li class="px-4 py-3">
                <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadMyScore(event)">
                    <span class="ml-4">My Score</span>
                </a>
            </li>

            <li class="px-4 py-3">
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                   class="block text-center text-white bg-[#ff0003] px-4 py-2 rounded-md hover:bg-red-700 
                          transition duration-300 ease-in-out transform hover:scale-105 shadow-md 
                          hover:shadow-red-500/50 flex items-center">
                    <span class="ml-4">Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-2 bg-black text-white flex flex-col justify-center items-center">
        <div class="flex items-center w-full justify-between px-4 md:px-0">
            <h1 class="text-2xl font-bold text-center md:text-left w-full">Welcome, Employee</h1>
        </div>
        
        <p class="mt-2 text-gray-400 text-center">Manage your tasks efficiently.</p>

        <!-- Dynamic Content Area -->
        <div id="contentArea" class="mt-8 p-8 bg-black shadow-lg rounded-2xl w-full h-[100vh] text-white overflow-auto">
            <p>Select an option from the sidebar.</p>
        </div>
    </div>

    <!-- JavaScript Functions -->
    <script>
        function toggleSidebar() {
            let sidebar = document.getElementById('mobileSidebar');
            sidebar.classList.toggle('-translate-x-full');
        }

        function loadDashboard(event) {
            event.preventDefault();
            $("#contentArea").html("<h2 class='text-xl'>Employee Dashboard</h2><p>Dashboard content goes here.</p>");
        }
function loadMyTasks(event) {
    event.preventDefault(); // Prevent page reload

    $.ajax({
        url: "/my-tasks", // Laravel route to fetch employee-specific tasks
        type: "GET",
        dataType: "json",
        success: function(response) {
            if (response.tasks.length === 0) {
                $("#contentArea").html("<p class='text-blue-500'>No tasks assigned to you.</p>");
                return;
            }

            let content = `
                <h2 class="text-2xl font-bold mb-4">My Tasks</h2>
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
                            <th class="border border-gray-600 p-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>`;

            response.tasks.forEach(task => {
                content += `
                    <tr class="bg-gray-900 hover:bg-gray-700">
                        <td class="border border-gray-600 p-2">${task.id}</td>
                        <td class="border border-gray-600 p-2">${task.task_title}</td>
                        <td class="border border-gray-600 p-2">${task.description}</td>

                        <td class="border border-gray-600 p-2">
                            <span class="px-2 py-1 text-black rounded ${getStatusClass(task.status)}">
                                ${task.status}
                            </span>
                        </td>
                        <td class="border border-gray-600 p-2">${task.task_create_date}</td>
                        <td class="border border-gray-600 p-2">
                            <input type="date" name="task_start_date" value="${task.task_start_date}" class="w-full p-1 rounded text-black" />
                        </td>
                        <td class="border border-gray-600 p-2">${task.no_of_days}</td>
                        <td class="border border-gray-600 p-2">${task.deadline}</td>
                        <td class="border border-gray-600 p-2">
                            <form class="status-update-form" data-task-id="${task.id}">
                                <select name="status" class="p-1 text-black rounded status-select" data-task-id="${task.id}">
                                    <option value="Pending" ${task.status === 'Pending' ? 'selected' : ''}>Pending</option>
                                    <option value="Started" ${task.status === 'Started' ? 'selected' : ''}>Started</option>
                                    <option value="Completed" ${task.status === 'Completed' ? 'selected' : ''}>Completed</option>
                                    <option value="Review" ${task.status === 'Review' ? 'selected' : ''}>Review</option>
                                </select>
                                <button type="submit" class="px-2 py-1 bg-green-600 text-white rounded ml-2 update-status-btn">Update</button>
                            </form>
                        </td>
                    </tr>`;
            });

            content += `</tbody></table>`;

            $("#contentArea").html(content); // Update the content area
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            $("#contentArea").html("<p class='text-red-500'>Failed to load tasks. Please try again later.</p>");
        }
    });
}

// Helper function for status colors
function getStatusClass(status) {
    switch (status.toLowerCase()) {
        case "pending": return "bg-yellow-500";
        case "started": return "bg-blue-500";
        case "completed": return "bg-green-500";
        case "review": return "bg-orange-500";
        default: return "bg-gray-500";
    }
}

// Event listener for status update
$(document).on("submit", ".status-update-form", function(event) {
    event.preventDefault(); // Prevent form submission
    
    let taskId = $(this).data("task-id");
    let status = $(this).find("select[name='status']").val();

    $.ajax({
        url: `/tasks/${taskId}/update-status`, // Laravel route to update task status
        type: "PATCH",
        data: { status: status, _token: $('meta[name="csrf-token"]').attr('content') }, // Ensure CSRF token is present
        success: function(response) {
            alert("Task status updated successfully!");
            loadMyTasks(event); // Reload tasks after update
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert("Failed to update task status. Please try again.");
        }
    });
});



        function loadMyProfile(event) {
            event.preventDefault();
            $("#contentArea").html("<h2 class='text-xl'>My Profile</h2><p>Your profile details.</p>");
        }

        function loadMyScore(event) {
            event.preventDefault();
            $("#contentArea").html("<h2 class='text-xl'>My Score</h2><p>Your performance score.</p>");
        }
    </script>

</body>
</html>
