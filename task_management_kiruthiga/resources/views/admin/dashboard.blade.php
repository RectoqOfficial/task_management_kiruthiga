
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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

<body class="bg-black flex h-screen ">
{{ session('user_role') }}

<!-- Sidebar -->
<div id="sidebar" class="w-64 bg-black h-screen p-4 hidden md:block">
    <a class="text-lg font-bold text-white block text-center mb-6" href="#">ADMIN PANEL</a>
    <ul class="text-sm"> <!-- Reduced font size -->      
        <li class="px-4 py-3">
            <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadDepartmentDetails(event)">
                <span class="icon-container w-5 h-5"></span>
                <span class="ml-4">Department & Role Details</span>
            </a>
        </li>
        <li class="px-4 py-3">
            <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadEmployeeDetails(event)" data-icon="employee">
                <span class="icon-container w-5 h-5"></span>
                <span class="ml-4">Employee Details</span>
            </a>
        </li>
        <li class="px-4 py-3">
            <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadTaskDetails(event)" data-icon="task">
                <span class="icon-container w-5 h-5"></span>
                <span class="ml-4">Task Details</span>
            </a>
        </li>
        <li class="px-4 py-3">
            <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadScoreDetails(event)" data-icon="score">
                <span class="icon-container w-5 h-5"></span>
                <span class="ml-4">Scoreboard</span>
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
<div id="mobileSidebar" class="fixed inset-0 bg-black w-64 p-4 transform -translate-x-full transition-transform duration-300 md:hidden">
    <button onclick="toggleSidebar()" class="absolute top-4 right-4 text-white text-2xl">×</button>
    <a class="text-lg font-bold text-white block text-center mb-6" href="#">ADMIN PANEL</a>
    <ul class="text-sm"> <!-- Reduced font size -->  
       <li class="px-4 py-3">
            <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadDepartmentDetails(event)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"></path>
                </svg>
                <span class="ml-4">Department & Role Details</span>
            </a>
        </li>
        
        <li class="px-4 py-3">
            <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadEmployeeDetails(event)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2-2-2"></path>
                </svg>
                <span class="ml-4">Employee Details</span>
            </a>
        </li>
        <li class="px-4 py-3">
            <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadTaskDetails(event)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                </svg>
                <span class="ml-4">Task Details</span>
            </a>
        </li>
        <li class="px-4 py-3">
            <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadScoreDetails(event)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5"></path>
                </svg>
                <span class="ml-4">Scoreboard</span>
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
        </li>
    </ul>
</div>


  <!-- Main Content -->
    <div class="flex-1 p-2 bg-black text-white flex flex-col justify-center items-center">
        <div class="flex items-center w-full justify-between px-4 md:px-0">
            <h1 class="text-2xl font-bold text-center md:text-left w-full">Welcome, you</h1>
        </div>
        
        <p class="mt-2 text-gray-400 text-center">Manage tasks and employees efficiently.</p>

   <!-- ========== Start Section ========== -->
    
        <!-- ========== Start Section ========== -->
<div id="contentArea" class="mt-8 p-8 bg-black shadow-lg rounded-2xl w-full h-[100vh] text-white overflow-auto">
    <!-- Task Count Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Tasks -->
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg text-center">
            <h3 class="text-lg font-semibold text-white">Total Tasks</h3>
            <p class="text-3xl font-bold text-blue-400">{{ $totalTasks }}</p>
        </div>

        <!-- Pending Tasks -->
        <div class="bg-yellow-600 p-6 rounded-lg shadow-lg text-center">
            <h3 class="text-lg font-semibold text-white">Pending Tasks</h3>
            <p class="text-3xl font-bold">{{ $pendingTasks }}</p>
        </div>

        <!-- Started Tasks -->
        <div class="bg-blue-600 p-6 rounded-lg shadow-lg text-center">
            <h3 class="text-lg font-semibold text-white">Started Tasks</h3>
            <p class="text-3xl font-bold">{{ $startedTasks }}</p>
        </div>

        <!-- Completed Tasks -->
        <div class="bg-green-600 p-6 rounded-lg shadow-lg text-center">
            <h3 class="text-lg font-semibold text-white">Completed Tasks</h3>
            <p class="text-3xl font-bold">{{ $completedTasks }}</p>
        </div>

        <!-- Review Tasks -->
        <div class="bg-purple-600 p-6 rounded-lg shadow-lg text-center">
            <h3 class="text-lg font-semibold text-white">Tasks in Review</h3>
            <p class="text-3xl font-bold">{{ $reviewTasks }}</p>
        </div>
    </div>
</div>
<!-- ========== End Section ========== -->

   <!-- ========== End Section ========== -->
   
        
    </div>

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

//icons 

    document.addEventListener("DOMContentLoaded", function () {
        const icons = {
            role: `<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"></path>
                   </svg>`,
            employee: `<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                          <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2-2"></path>
                      </svg>`,
            task: `<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                   </svg>`,
            score: `<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                       <path d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5"></path>
                   </svg>`
        };

        document.querySelectorAll("a[data-icon]").forEach((link) => {
            const iconName = link.getAttribute("data-icon");
            const iconContainer = link.querySelector(".icon-container");

            if (icons[iconName]) {
                iconContainer.innerHTML = icons[iconName];
            }
        });
    });


// Function to load Role Details content into the #contentArea div
function loadDepartmentDetails(event) {
    event.preventDefault(); // Prevent the default behavior of the link/button click

    $.ajax({
        url: "/admin/departments",  // The correct endpoint for fetching department details
        method: "GET",  // HTTP GET request
        dataType: "html",  // Expecting an HTML response
        success: function (response) {
               console.log("✅ Department details loaded successfully!");
            $("#contentArea").html(response);  // Inject the response into the target div
            closeMobileSidebar();  // Close sidebar (if applicable)
        },
        error: function (xhr, status, error) {
            console.error(" AJAX Error: ", xhr.responseText);
            alert("Error loading department details: " + xhr.responseText);  // Show error message
            $("#contentArea").html('<p class="text-red-500">Failed to load Department Details.</p>'); // Display failure message
        },
    });
}

// Function to load Employee Details content into the #contentArea div
function loadEmployeeDetails(event) {
    event.preventDefault(); // Prevent default behavior

   $.ajax({
    url: '/admin/employees',
    method: 'GET',
    success: function(response) {
        console.log(response); // Log response to see what data is returned
        $('#contentArea').html(response);
        closeMobileSidebar();
    },
    error: function(xhr, status, error) {
        console.error('Error loading employee details:', error);
        alert('Error loading employee details! ' + error);
        console.log(xhr.responseText); // Log the actual error response for better debugging
        $('#contentArea').html('<p class="text-red-500">Failed to load Employee Details.</p>');
    }
});

}


// Function to load Task Details content into the #contentArea div
// Function to load Task Details content into the #contentArea div
function loadTaskDetails(event) {
    event.preventDefault(); // Prevent default behavior (navigation)

    $.ajax({
        url: "/tasks", // The route for fetching tasks
        method: 'GET',
        success: function(response) {
            $('#contentArea').html(response); // Inject the response into the content area
            closeMobileSidebar(); // If you have a mobile sidebar
        },
        error: function(xhr, status, error) {
            alert('Error loading task details! ' + error); // Error handling
            $('#contentArea').html('<p class="text-red-500">Failed to load Task Details.</p>');
        }
    });
}




// Function to load Scoreboard content into the #contentArea div
function loadScoreDetails(event) {
    event.preventDefault(); // Prevent default behavior

    $.ajax({
        url: "/scores", // Updated URL to match scoreboard route
        method: 'GET',
        success: function(response) {
            $('#contentArea').html(response); // Inject the response into the content area
            closeMobileSidebar(); 
        },
        error: function(xhr, status, error) {
            alert('Error loading scoreboard details! ' + error); // Show an error message
            $('#contentArea').html('<p class="text-red-500">Failed to load Scoreboard Details.</p>');
        }
    });
}


    </script>
</body>
</html>