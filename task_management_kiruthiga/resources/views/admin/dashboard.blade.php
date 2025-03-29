
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

<body class="bg-gray-100 flex h-screen ">

    <!-- Sidebar -->
  <div id="sidebar" class="w-64 bg-gray-900 h-screen p-4 hidden md:block">
        <a class="text-lg font-bold text-white block text-center mb-6" href="#">ADMIN PANEL</a>
        <ul>
     <!-- Sidebar -->

    <li class="px-4 py-3">
        <a href="#" class="flex items-center text-gray-300 hover:text-purple-400" onclick="loadRoleDetails(event)" data-icon="role">
            <span class="icon-container w-5 h-5"></span>
            <span class="ml-4">Role Details</span>
        </a>
    </li>

    <li class="px-4 py-3">
        <a href="#" class="flex items-center text-gray-300 hover:text-purple-400" onclick="loadEmployeeDetails(event)" data-icon="employee">
            <span class="icon-container w-5 h-5"></span>
            <span class="ml-4">Employee Details</span>
        </a>
    </li>

    <li class="px-4 py-3">
        <a href="#" class="flex items-center text-gray-300 hover:text-purple-400" onclick="loadTaskDetails(event)" data-icon="task">
            <span class="icon-container w-5 h-5"></span>
            <span class="ml-4">Task Details</span>
        </a>
    </li>

    <li class="px-4 py-3">
        <a href="#" class="flex items-center text-gray-300 hover:text-purple-400" onclick="loadScoreDetails(event)" data-icon="score">
            <span class="icon-container w-5 h-5"></span>
            <span class="ml-4">Scoreboard</span>
        </a>
    </li>



             <!-- Logout Button -->
            <li class="px-4 py-3">
                <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
               class="block text-center text-white bg-purple-600 px-4 py-2 rounded-md hover:bg-purple-700 
                      transition duration-300 ease-in-out transform hover:scale-105 shadow-md 
                      hover:shadow-purple-500/50 flex items-center">
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
        <button onclick="toggleSidebar()" class="bg-gray-900 text-white p-2 rounded-md">
            ☰ Menu
        </button>
    </div>

 <!-- Mobile Sidebar -->
<div id="mobileSidebar" class="fixed inset-0 bg-gray-900 w-64 p-4 transform -translate-x-full transition-transform duration-300 md:hidden">
    <button onclick="toggleSidebar()" class="absolute top-4 right-4 text-white text-2xl">×</button>
    <a class="text-lg font-bold text-white block text-center mb-6" href="#">ADMIN PANEL</a>
    <ul>
        <li class="px-4 py-3">
            <a href="#" class="flex items-center text-gray-300 hover:text-purple-400" onclick="loadRoleDetails(event)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"></path>
                </svg>
                <span class="ml-4">Role Details</span>
            </a>
        </li>

        <li class="px-4 py-3">
            <a href="#" class="flex items-center text-gray-300 hover:text-purple-400" onclick="loadEmployeeDetails(event)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2-2-2"></path>
                </svg>
                <span class="ml-4">Employee Details</span>
            </a>
        </li>

        <li class="px-4 py-3">
            <a href="#" class="flex items-center text-gray-300 hover:text-purple-400" onclick="loadTaskDetails(event)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                </svg>
                <span class="ml-4">Task Details</span>
            </a>
        </li>

        <li class="px-4 py-3">
            <a href="#" class="flex items-center text-gray-300 hover:text-purple-400" onclick="loadScoreDetails(event)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5"></path>
                </svg>
                <span class="ml-4">Scoreboard</span>
            </a>
        </li>

        <li class="px-4 py-3">
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
               class="block text-center text-white bg-purple-600 px-4 py-2 rounded-md hover:bg-purple-700 
                      transition duration-300 ease-in-out transform hover:scale-105 shadow-md 
                      hover:shadow-purple-500/50 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6-8V3m0 18v-2"></path>
                </svg>
                Logout
            </a>
        </li>
    </ul>
</div>


  <!-- Main Content -->
    <div class="flex-1 p-2 bg-gray-900 text-white flex flex-col justify-center items-center">
        <div class="flex items-center w-full justify-between px-4 md:px-0">
            <h1 class="text-2xl font-bold text-center md:text-left w-full">Welcome, you</h1>
        </div>
        
        <p class="mt-2 text-gray-400 text-center">Manage tasks and employees efficiently.</p>

   <!-- ========== Start Section ========== -->
     <div id="contentArea" class="mt-8 p-8 bg-gray-900 shadow-lg rounded-2xl w-full h-[100vh] text-white overflow-auto">
         
        </div>
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
function loadRoleDetails(event) {
    event.preventDefault(); // Prevent default behavior

    $.ajax({
        url: "http://127.0.0.1:8000/roles", // The correct URL for the 'roles' route
        method: 'GET',
        success: function(response) {
            $('#contentArea').html(response); 
             closeMobileSidebar(); // Inject the response into the content area
        },
        error: function(xhr, status, error) {
            alert('Error loading role details! ' + error); // Show an error message
        }
    });
}
// Function to load Employee Details content into the #contentArea div
function loadEmployeeDetails(event) {
    event.preventDefault(); // Prevent default behavior

    $.ajax({
        url: "http://127.0.0.1:8000/employee-details", // This matches the route you defined
        method: 'GET',
        success: function(response) {
            $('#contentArea').html(response); // Inject the response into the content area
              closeMobileSidebar(); 
        },
        error: function(xhr, status, error) {
            alert('Error loading employee details! ' + error); // Show an error message
        }
    });
}

// Function to load Task Details content into the #contentArea div
function loadTaskDetails(event) {
    event.preventDefault(); // Prevent default behavior

    $.ajax({
        url: "http://127.0.0.1:8000/task", // This should match your task details route
        method: 'GET',
        success: function(response) {
            $('#contentArea').html(response); // Inject the response into the content area
              closeMobileSidebar(); 
        },
        error: function(xhr, status, error) {
            alert('Error loading task details! ' + error); // Show an error message
        }
    });
}
// Function to load Scoreboard content into the #contentArea div
function loadScoreDetails(event) {
    event.preventDefault(); // Prevent default behavior

    $.ajax({
        url: "http://127.0.0.1:8000/tasks/score_details", // The correct URL for the scoreboard route
        method: 'GET',
        success: function(response) {
            $('#contentArea').html(response); // Inject the response into the content area
            closeMobileSidebar(); 
        },
        error: function(xhr, status, error) {
            alert('Error loading scoreboard details! ' + error); // Show an error message
        }
    });
}

    </script>
</body>
</html>