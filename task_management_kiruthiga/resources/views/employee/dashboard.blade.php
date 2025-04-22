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
<body class="bg-black flex flex-col md:flex-row h-screen">

    <!-- Sidebar -->
    <div id="sidebar" class="w-full md:w-64 bg-black h-auto md:h-screen p-4 hidden md:block">
        <a class="text-lg font-bold text-white block text-center mb-6 animate-pulse" href="#">EMPLOYEE PANEL</a>
        <style>
            @keyframes pulse {
            0%, 100% {
                color: #ffffff; /* White */
            }
            50% {
                color: #ff0003; /* Red */
            }
            }
            .animate-pulse {
            animation: pulse 2s infinite;
            }
        </style>
        <ul>
 <li class="px-4 py-3">
    <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadDashboard(event)">
        <span class="icon-container w-5 h-5">
               <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 10h18M3 14h18M5 6h14M5 18h14"></path>
            </svg>
        </span>
        <span class="ml-4">Dashboard</span>
    </a>
</li>

            <li class="px-4 py-3">
    <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadMyTasks(event)">
        <span class="icon-container w-5 h-5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 12h6m-3-3v6m-7 4h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </span>
        <span class="ml-4">My Task</span>
    </a>
</li>


            <li class="px-4 py-3">
                <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadMyProfile(event)">
                       <span class="icon-container w-5 h-5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm0 2c-2.21 0-4 1.79-4 4v1h8v-1c0-2.21-1.79-4-4-4z"></path>
                        </svg>
                    </span>
                    <span class="ml-4">My Profile</span>
                </a>
            </li>

            <li class="px-4 py-3">
                <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadMyScore(event)">
                     <span class="icon-container w-5 h-5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 8c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm0 2c-2.21 0-4 1.79-4 4v1h8v-1c0-2.21-1.79-4-4-4zm0 6c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z"></path>
                        </svg>
                    </span>
                    <span class="ml-4">My Score</span>
                </a>
            </li>
<li class="px-4 py-3">
    <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadMyLeave(event)">
        <span class="icon-container w-5 h-5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2v-6H3v6a2 2 0 002 2z"></path>
            </svg>
        </span>
        <span class="ml-4">My Leave</span>
    </a>
</li>

<li class="px-4 py-3">
    <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadMySalary(event)">
        <span class="icon-container w-5 h-5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 8c-1.657 0-3 1.343-3 3 0 1.657 1.343 3 3 3m0-6c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3m0 6v6m-3-3h6"></path>
            </svg>
        </span>
        <span class="ml-4">My Salary</span>
    </a>
</li>

<li class="px-4 py-3">
    <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadMyRating(event)">
        <span class="icon-container w-5 h-5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 17.27L18.18 21l-1.45-6.21L22 9.24l-6.36-.54L12 3 9.36 8.7 3 9.24l5.27 5.55L6.82 21z"></path>
            </svg>
        </span>
        <span class="ml-4">My Rating</span>
    </a>
</li>

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
            ☰ 
        </button>
    </div>

    <!-- Mobile Sidebar -->
     <div id="mobileSidebar" class="fixed inset-0 z-50 bg-black w-64 p-4 transform -translate-x-full transition-transform duration-300 md:hidden">
        <button onclick="toggleSidebar()" class="absolute top-4 right-4 text-white text-2xl">×</button>
   <a class="text-lg font-bold text-white block text-center mb-6 animate-pulse" href="#">EMPLOYEE PANEL</a>
        <ul>
            <li class="px-4 py-3">
                <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadDashboard(event)">
                    <span class="icon-container w-5 h-5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 10h18M3 14h18M5 6h14M5 18h14"></path>
            </svg>
        </span>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>

            <li class="px-4 py-3">
                <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadMyTasks(event)">
                    <span class="icon-container w-5 h-5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 12h6m-3-3v6m-7 4h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </span>
                    <span class="ml-4">My Tasks</span>
                </a>
            </li>

            <li class="px-4 py-3">
                <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadMyProfile(event)">
                    <span class="icon-container w-5 h-5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm0 2c-2.21 0-4 1.79-4 4v1h8v-1c0-2.21-1.79-4-4-4z"></path>
                        </svg>
                    </span>
                    <span class="ml-4">My Profile</span>
                </a>
            </li>

            <li class="px-4 py-3">
                <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadMyScore(event)">
                    <span class="icon-container w-5 h-5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 8c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm0 2c-2.21 0-4 1.79-4 4v1h8v-1c0-2.21-1.79-4-4-4zm0 6c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z"></path>
                        </svg>
                    </span>
                    <span class="ml-4">My Score</span>
                </a>
            </li>

<li class="px-4 py-3">
    <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadMyLeave(event)">
        <span class="icon-container w-5 h-5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2v-6H3v6a2 2 0 002 2z"></path>
            </svg>
        </span>
        <span class="ml-4">My Leave</span>
    </a>
</li>

<li class="px-4 py-3">
    <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadMySalary(event)">
        <span class="icon-container w-5 h-5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 8c-1.657 0-3 1.343-3 3 0 1.657 1.343 3 3 3m0-6c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3m0 6v6m-3-3h6"></path>
            </svg>
        </span>
        <span class="ml-4">My Salary</span>
    </a>
</li>

<li class="px-4 py-3">
    <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadMyRating(event)">
        <span class="icon-container w-5 h-5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 17.27L18.18 21l-1.45-6.21L22 9.24l-6.36-.54L12 3 9.36 8.7 3 9.24l5.27 5.55L6.82 21z"></path>
            </svg>
        </span>
        <span class="ml-4">My Rating</span>
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

        </div>
       <div id="employee-dashboard" style="display: none;">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Tasks -->
        <div class="bg-gray-800 p-4 sm:p-6 rounded-lg shadow-lg text-center">
            <h3 class="text-sm sm:text-lg font-semibold text-white">Total Tasks</h3>
            <p class="text-2xl sm:text-3xl font-bold text-blue-400">{{ $totalTasks }}</p>
        </div>

        <!-- Pending Tasks -->
        <div class="bg-yellow-600 p-4 sm:p-6 rounded-lg shadow-lg text-center">
            <h3 class="text-sm sm:text-lg font-semibold text-white">Pending Tasks</h3>
            <p class="text-2xl sm:text-3xl font-bold">{{ $pendingTasks }}</p>
        </div>

        <!-- Started Tasks -->
        <div class="bg-blue-600 p-4 sm:p-6 rounded-lg shadow-lg text-center">
            <h3 class="text-sm sm:text-lg font-semibold text-white">Started Tasks</h3>
            <p class="text-2xl sm:text-3xl font-bold">{{ $startedTasks }}</p>
        </div>

        <!-- Completed Tasks -->
        <div class="bg-green-600 p-4 sm:p-6 rounded-lg shadow-lg text-center">
            <h3 class="text-sm sm:text-lg font-semibold text-white">Completed Tasks</h3>
            <p class="text-2xl sm:text-3xl font-bold">{{ $completedTasks }}</p>
        </div>

        <!-- Review Tasks -->
        <div class="bg-purple-600 p-4 sm:p-6 rounded-lg shadow-lg text-center">
            <h3 class="text-sm sm:text-lg font-semibold text-white">Tasks in Review</h3>
            <p class="text-2xl sm:text-3xl font-bold">{{ $reviewTasks }}</p>
        </div>
    </div>
</div>

    

   <!-- Dynamic Content Area -->
        <div id="contentArea" class="mt-8 p-8 bg-black shadow-lg rounded-2xl w-full h-[100vh] text-white overflow-auto">
              
          
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

    // Optionally close mobile sidebar if open
    const sidebar = document.getElementById("mobileSidebar");
    if (sidebar && !sidebar.classList.contains("-translate-x-full")) {
        sidebar.classList.add("-translate-x-full");
    }

    // Get the employee dashboard content
    const dashboardContent = document.getElementById("employee-dashboard").innerHTML;

    // Inject it into the mainContent section
    document.getElementById("contentArea").innerHTML = dashboardContent;
}



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
              dataType: "html", // Expecting HTML response
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
function loadMyLeave(event) {
    event.preventDefault();
    $.ajax({
        url: "/employee/leave",
        type: "GET",
        success: function(response) {
            $("#contentArea").html(response);
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert("Error loading score.");
        }
    }); // Load "My Leave" content via AJAX or redirect
}

function loadMySalary(event) {
    event.preventDefault();
    // Load "My Salary" content via AJAX or redirect
}

function loadMyRating(event) {
    event.preventDefault();
    // Load "My Rating" content via AJAX or redirect
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
