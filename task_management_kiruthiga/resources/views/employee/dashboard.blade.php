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
              <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full p-4">
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
        <p class="mt-2 text-gray-400 text-center">Manage your tasks efficiently.</p>
        
  


        <!-- Dynamic Content Area -->
        <div id="contentArea" class="mt-8 p-8 bg-black shadow-lg rounded-2xl w-full h-[100vh] text-white overflow-auto">
            <p>Select an option from the sidebar.</p>
        </div>
    </div>

    <!-- JavaScript Functions -->
    <script>



function toggleSidebar() {
    let sidebar = document.getElementById("mobileSidebar");
    if (sidebar.classList.contains("-translate-x-full")) {
        sidebar.classList.remove("-translate-x-full");
    } else {
        sidebar.classList.add("-translate-x-full");
    }
}

function closeMobileSidebar() {
    let sidebar = document.getElementById("mobileSidebar");
    if (!sidebar.classList.contains("-translate-x-full")) {
        sidebar.classList.add("-translate-x-full");
    }
}

// Close the sidebar when a menu item is clicked
document.querySelectorAll("#mobileSidebar ul li a").forEach(item => {
    item.addEventListener("click", function () {
        closeMobileSidebar();
    });
});


        function loadDashboard(event) {
            event.preventDefault();
            $("#contentArea").html("<h2 class='text-xl'>Employee Dashboard</h2><p>Dashboard content goes here.</p>");
        }
// function loadMyTasks(event) {
//     event.preventDefault(); // Prevent page reload
//   $("#contentArea").html("<h2 class='text-xl'>My Task</h2><p>Your task details.</p>");
    
// }
function loadMyTasks(event) {
    event.preventDefault(); // Prevent full page reload

    $.ajax({
        url: "{{ route('employee.tasks') }}", // Ensure the route is defined in web.php
        type: "GET",
        dataType: "html", // Expecting HTML response
        success: function(response) {
            console.log("Tasks loaded successfully!");
            $("#contentArea").html(response); // Inject the response into the content area
        },
        error: function(xhr, status, error) {
            console.error("Error loading tasks:", xhr.responseText);
            alert("Failed to load tasks. Check console for details.");
        }
    });
}




      function loadMyProfile(event) {
    event.preventDefault();

    $.ajax({
        url: "/employee/profile",
        type: "GET",
        success: function(response) {
            $("#contentArea").html(response);
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert("Error loading profile.");
        }
    });
}


      function loadMyScore(event) {
    event.preventDefault();

    $.ajax({
        url: "/employee/score",
        type: "GET",
        success: function(response) {
            $("#contentArea").html(response);
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert("Error loading score.");
        }
    });
}


//dashboard
$(document).ready(function () {
    // Fetch dashboard stats when the page loads
    fetchDashboardStats();
});

function fetchDashboardStats() {
    $.ajax({
        url: "{{ route('employee.dashboard.stats') }}", // Ensure this route exists in web.php
        type: "GET",
        dataType: "json",
        success: function (data) {
            $("#taskCount").text(data.task_count);
            $("#progressTaskCount").text(data.in_progress_tasks);
            $("#taskScore").text(data.task_score);
        },
        error: function (xhr) {
            console.error("Error fetching stats:", xhr.responseText);
        }
    });
}
    </script>

</body>
</html>
