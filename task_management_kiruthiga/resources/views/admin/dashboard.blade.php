
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
    .thin-scrollbar {
        scrollbar-width: thin; /* For Firefox */
        scrollbar-color: #4B5563 transparent; /* For Firefox */
    }

    .thin-scrollbar::-webkit-scrollbar {
        width: 6px; /* For Chrome, Edge, and Safari */
    }

    .thin-scrollbar::-webkit-scrollbar-thumb {
        background-color: #4B5563; /* Gray color for the scrollbar thumb */
        border-radius: 10px;
    }

    .thin-scrollbar::-webkit-scrollbar-track {
        background: transparent; /* Transparent track */
    }

</style>

</head>

<body class="bg-black flex h-screen ">
    
{{ session('user_role') }}

<!-- Sidebar -->
<div id="sidebar" class="w-64 bg-black h-screen p-4 hidden md:block ">
    <a class="text-lg font-bold text-white block text-center mb-6 animate-pulse" href="#">ADMIN PANEL</a>
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
              .active-link {
        color: #ff0003 !important;
        font-weight: bold;
    }
        </style>
    <ul class="text-sm"> <!-- Reduced font size -->   
        <li class="px-4 py-3">
        <a href="#" id="dashboardLink" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadDashboard(event)">
        <span class="icon-container w-5 h-5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M3 10h18M3 14h18M5 6h14M5 18h14"></path>
            </svg>
        </span>
        <span class="ml-4">Dashboard</span>
        </a>
    </li>
        <li class="px-4 py-3">
            <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadDepartmentDetails(event) " id="departmentLink">
                <span class="icon-container w-5 h-5">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"></path>
                </svg>
                </span>
                <span class="ml-4">Department & Role Details</span>
            </a>
        </li>
        <li class="px-4 py-3">
            <a href="#" id="employeeLink" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadEmployeeDetails(event)" data-icon="employee">
                  <span class="icon-container w-5 h-5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm0 2c-2.21 0-4 1.79-4 4v1h8v-1c0-2.21-1.79-4-4-4z"></path>
                        </svg>
                    </span>
                <span class="ml-4">Employee Details</span>
            </a>
        </li>
        <li class="px-4 py-3">
            <a href="#" id="taskLink" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadTaskDetails(event)" data-icon="task">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 12h6m-3-3v6m-7 4h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </span>
                <span class="ml-4">Task Details</span>
            </a>
        </li>
        <li class="px-4 py-3">
            <a href="#" id="scoreLink" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadScoreDetails(event)" data-icon="score">
                  <span class="icon-container w-5 h-5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 8c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm0 2c-2.21 0-4 1.79-4 4v1h8v-1c0-2.21-1.79-4-4-4zm0 6c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z"></path>
                        </svg>
                    </span>
                <span class="ml-4">Scoreboard</span>
            </a>
        </li>
         <!-- New Employee Leave Details -->
    <li class="px-4 py-3">
        <a href="#" id="leaveDetailsLink" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadLeaveDetails(event)">
            <span class="icon-container w-5 h-5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2v-6H3v6a2 2 0 002 2z"></path>
            </svg>
            </span>
            <span class="ml-4">Employee Leave Details</span>
        </a>
    </li>

    <!-- New Employee Salary Details -->
    <li class="px-4 py-3">
        <a href="#" id="salaryDetailsLink" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadSalaryDetails(event)">
            <span class="icon-container w-5 h-5">
               <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 8c-1.657 0-3 1.343-3 3 0 1.657 1.343 3 3 3m0-6c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3m0 6v6m-3-3h6"></path>
            </svg>
            </span>
            <span class="ml-4">Employee Salary Details</span>
        </a>
    </li>

    <!-- New Employee Rating -->
    <li class="px-4 py-3">
        <a href="#" id="ratingLink" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadEmployeeRating(event)">
            <span class="icon-container w-5 h-5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 17.27L18.18 21l-1.45-6.21L22 9.24l-6.36-.54L12 3 9.36 8.7 3 9.24l5.27 5.55L6.82 21z"></path>
            </svg>
            </span>
            <span class="ml-4">Employee Rating</span>
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
   <a class="text-lg font-bold text-white block text-center mb-6 animate-pulse" href="#">ADMIN PANEL</a>
    <ul class="text-sm"> <!-- Reduced font size -->  
<li class="px-4 py-3">
    <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadDashboard(event); closeMobileSidebar()">
        <span class="icon-container w-5 h-5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 10h18M3 14h18M5 6h14M5 18h14"></path>
            </svg>
        </span>
        <span class="ml-4">Dashboard</span>
    </a>
</li>

        <li class="px-4 py-3">
            <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadDepartmentDetails(event)">
                <span class="icon-container w-5 h-5">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"></path>
                </svg>
                </span>
                <span class="ml-4">Department & Role Details</span>
            </a>
        </li>
        
        <li class="px-4 py-3">
            <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadEmployeeDetails(event)">
                  <span class="icon-container w-5 h-5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm0 2c-2.21 0-4 1.79-4 4v1h8v-1c0-2.21-1.79-4-4-4z"></path>
                        </svg>
                    </span>
                <span class="ml-4">Employee Details</span>
            </a>
        </li>
        <li class="px-4 py-3">
            <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadTaskDetails(event)">
                <span class="icon-container w-5 h-5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 12h6m-3-3v6m-7 4h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </span>
                <span class="ml-4">Task Details</span>
            </a>
        </li>
        <li class="px-4 py-3">
            <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadScoreDetails(event)">
                <span class="icon-container w-5 h-5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 8c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm0 2c-2.21 0-4 1.79-4 4v1h8v-1c0-2.21-1.79-4-4-4zm0 6c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z"></path>
                        </svg>
                    </span>
                <span class="ml-4">Scoreboard</span>
            </a>
        </li>
         <!-- New Employee Leave Details -->
    <li class="px-4 py-3">
        <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadLeaveDetails(event); closeMobileSidebar()">
            <span class="icon-container w-5 h-5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2v-6H3v6a2 2 0 002 2z"></path>
            </svg>
            </span>
            <span class="ml-4">Employee Leave Details</span>
        </a>
    </li>

    <!-- New Employee Salary Details -->
    <li class="px-4 py-3">
        <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadSalaryDetails(event); closeMobileSidebar()">
            <span class="icon-container w-5 h-5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 8c-1.657 0-3 1.343-3 3 0 1.657 1.343 3 3 3m0-6c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3m0 6v6m-3-3h6"></path>
            </svg>
            </span>
            <span class="ml-4">Employee Salary Details</span>
        </a>
    </li>

    <!-- New Employee Rating -->
    <li class="px-4 py-3">
        <a href="#" class="flex items-center text-gray-300 hover:text-red-400" onclick="loadEmployeeRating(event); closeMobileSidebar()">
            <span class="icon-container w-5 h-5">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 17.27L18.18 21l-1.45-6.21L22 9.24l-6.36-.54L12 3 9.36 8.7 3 9.24l5.27 5.55L6.82 21z"></path>
            </svg>
            </span>
            <span class="ml-4">Employee Rating</span>
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

        </div>
        
      

 <!-- ========== Start Section ========== -->
<div id="contentArea" class="mt-8 p-8 bg-black shadow-lg rounded-2xl w-full h-[80vh] text-white"> 
    <!-- Dashboard Section -->
    <div id="dashboard" class="hidden">
   <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Total Tasks -->
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg text-center transform transition duration-300 ease-in-out hover:scale-105 hover:shadow-2xl">
        <h3 class="text-lg font-semibold text-white">Total Tasks</h3>
        <p class="text-3xl font-bold text-blue-400">{{ $totalTasks }}</p>
    </div>

    <!-- Pending Tasks -->
    <div class="bg-yellow-600 p-6 rounded-lg shadow-lg text-center transform transition duration-300 ease-in-out hover:scale-105 hover:shadow-2xl">
        <h3 class="text-lg font-semibold text-white">Pending Tasks</h3>
        <p class="text-3xl font-bold">{{ $pendingTasks }}</p>
    </div>

    <!-- Started Tasks -->
    <div class="bg-blue-600 p-6 rounded-lg shadow-lg text-center transform transition duration-300 ease-in-out hover:scale-105 hover:shadow-2xl">
        <h3 class="text-lg font-semibold text-white">Started Tasks</h3>
        <p class="text-3xl font-bold">{{ $startedTasks }}</p>
    </div>

    <!-- Completed Tasks -->
    <div class="bg-green-600 p-6 rounded-lg shadow-lg text-center transform transition duration-300 ease-in-out hover:scale-105 hover:shadow-2xl">
        <h3 class="text-lg font-semibold text-white">Completed Tasks</h3>
        <p class="text-3xl font-bold">{{ $completedTasks }}</p>
    </div>

    <!-- Review Tasks -->
    <div class="bg-purple-600 p-6 rounded-lg shadow-lg text-center transform transition duration-300 ease-in-out hover:scale-105 hover:shadow-2xl">
        <h3 class="text-lg font-semibold text-white">Tasks in Review</h3>
        <p class="text-3xl font-bold">{{ $reviewTasks }}</p>
    </div>
</div>

<!-- Top Performers Section -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
    <!-- Top Performer - Last 3 Months -->
    <div class="bg-indigo-700 p-6 rounded-lg shadow-lg text-center transform transition duration-300 ease-in-out hover:scale-105 hover:shadow-2xl">
        <h3 class="text-lg font-semibold text-white">Top Performer (Last 3 Months)</h3>
        @if ($top3Months)
            <p class="text-xl font-bold text-green-300">{{ $top3Months->employee->full_name }}</p>
            <p class="text-white mt-2">{{ $top3Months->completed_count }} tasks completed</p>
        @else
            <p class="text-white mt-2">No data</p>
        @endif
    </div>

    <!-- Top Performer - Last 6 Months -->
    <div class="bg-teal-700 p-6 rounded-lg shadow-lg text-center transform transition duration-300 ease-in-out hover:scale-105 hover:shadow-2xl">
        <h3 class="text-lg font-semibold text-white">Top Performer (Last 6 Months)</h3>
        @if ($top6Months)
            <p class="text-xl font-bold text-green-300">{{ $top6Months->employee->full_name }}</p>
            <p class="text-white mt-2">{{ $top6Months->completed_count }} tasks completed</p>
        @else
            <p class="text-white mt-2">No data</p>
        @endif
    </div>

    <!-- Top Performer - Last 1 Year -->
    <div class="bg-pink-700 p-6 rounded-lg shadow-lg text-center transform transition duration-300 ease-in-out hover:scale-105 hover:shadow-2xl">
        <h3 class="text-lg font-semibold text-white">Top Performer (Last 1 Year)</h3>
        @if ($top1Year)
            <p class="text-xl font-bold text-green-300">{{ $top1Year->employee->full_name }}</p>
            <p class="text-white mt-2">{{ $top1Year->completed_count }} tasks completed</p>
        @else
            <p class="text-white mt-2">No data</p>
        @endif
    </div>
</div>

     </div>

     
</div>
<!-- ========== End Section ========== -->


   
        
    </div>

<script>
    function setActiveLink(linkId) {
        const links = ['dashboardLink', 'departmentLink', 'employeeLink', 'taskLink', 'scoreLink','leaveDetailsLink','salaryDetailsLink','ratingLink',];
        links.forEach(id => {
            const link = document.getElementById(id);
            if (link) {
                link.classList.remove('active-link');
            }
        });

        const activeLink = document.getElementById(linkId);
        if (activeLink) {
            activeLink.classList.add('active-link');
        }
    }
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

// Function to hide all sections (Dashboard, Department, Employee, Task, Score)
function hideAllSections() {
    const dashboardElement = document.getElementById("dashboard");
    if (dashboardElement) {
        dashboardElement.classList.add("hidden");
    }

    // Hide other sections
    const otherSections = ['departmentDetails', 'employeeDetails', 'taskDetails', 'scoreDetails'];
    otherSections.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.classList.add("hidden");
    });
}

// Function to load the Dashboard section
function loadDashboard(event) {
    event.preventDefault();  // Prevent the default link behavior
    setActiveLink('dashboardLink');
    hideAllSections();  // Hide all sections

    const dashboardElement = document.getElementById("dashboard");
    if (dashboardElement) {
        dashboardElement.classList.remove("hidden");  // Show the dashboard
    } else {
        console.error('Dashboard element not found!');
    }
}

// Function to load Department Details into the #contentArea div
function loadDepartmentDetails(event) {
    event.preventDefault();  // Prevent the default behavior of the link/button click
    setActiveLink('departmentLink');
    window.API_BASE_URL = "{{ env('MIX_API_URL') }}";
    console.log("API Base URL:", API_BASE_URL);
    let $api_url = window.API_BASE_URL + "/admin/departments";

    $.ajax({
        url: $api_url,  // The correct endpoint for fetching department details
        method: "GET",  // HTTP GET request
        dataType: "html",  // Expecting an HTML response
        success: function (response) {
            console.log("✅ Department details loaded successfully!");
            $("#contentArea").html(response);  // Inject the response into the target div
            closeMobileSidebar();  // Close sidebar (if applicable)
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: ", xhr.responseText);
            alert("Error loading department details: " + xhr.responseText);  // Show error message
            $("#contentArea").html('<p class="text-red-500">Failed to load Department Details.</p>');  // Display failure message
        },
    });
}

// Function to load Employee Details into the #contentArea div
function loadEmployeeDetails(event) {
    event.preventDefault();  // Prevent default behavior
    setActiveLink('employeeLink');
    window.API_BASE_URL = "{{ env('MIX_API_URL') }}";
    console.log("API Base URL:", API_BASE_URL);
    let $api_url = window.API_BASE_URL + "/admin/employees";

    $.ajax({
        url: $api_url,  // Endpoint to fetch employee details
        method: "GET",  // HTTP GET request
        success: function (response) {
            console.log(response);  // Log response to see what data is returned
            $('#contentArea').html(response);  // Inject the response into the content area
            closeMobileSidebar();  // Close mobile sidebar (if applicable)
        },
        error: function (xhr, status, error) {
            console.error('Error loading employee details:', error);
            alert('Error loading employee details! ' + error);
            console.log(xhr.responseText);  // Log the actual error response for better debugging
            $('#contentArea').html('<p class="text-red-500">Failed to load Employee Details.</p>');  // Display failure message
        },
    });
}

// Function to load Task Details into the #contentArea div
function loadTaskDetails(event) {
    event.preventDefault();  // Prevent default behavior (navigation)
    setActiveLink('taskLink');
    window.API_BASE_URL = "{{ env('MIX_API_URL') }}";
    console.log("API Base URL:", API_BASE_URL);
    let $api_url = window.API_BASE_URL + "/tasks";

    $.ajax({
        url: $api_url,  // The route for fetching tasks
        method: 'GET',  // HTTP GET request
        success: function (response) {
            $('#contentArea').html(response);  // Inject the response into the content area
            closeMobileSidebar();  // Close mobile sidebar (if applicable)
        },
        error: function (xhr, status, error) {
            alert('Error loading task details! ' + error);  // Show error message
            $('#contentArea').html('<p class="text-red-500">Failed to load Task Details.</p>');  // Display failure message
        },
    });
}

// Function to load Scoreboard Details into the #contentArea div
function loadScoreDetails(event) {
    event.preventDefault();  // Prevent default behavior
    setActiveLink('scoreLink');
    window.API_BASE_URL = "{{ env('MIX_API_URL') }}";
    console.log("API Base URL:", API_BASE_URL);
    let $api_url = window.API_BASE_URL + "/scores";

    $.ajax({
        url: $api_url,  // Updated URL to match scoreboard route
        method: 'GET',  // HTTP GET request
        success: function (response) {
            $('#contentArea').html(response);  // Inject the response into the content area
            closeMobileSidebar();  // Close mobile sidebar (if applicable)
        },
        error: function (xhr, status, error) {
            alert('Error loading scoreboard details! ' + error);  // Show an error message
            $('#contentArea').html('<p class="text-red-500">Failed to load Scoreboard Details.</p>');  // Display failure message
        },
    });
}
   function loadLeaveDetails(event) {
        event.preventDefault(); // Stop default link behavior
        setActiveLink('leaveDetailsLink'); // Highlight active sidebar link
  window.API_BASE_URL = "{{ env('MIX_API_URL') }}";
    console.log("API Base URL:", API_BASE_URL);
    let $api_url = window.API_BASE_URL + "/admin/leave";
       // Route that returns the leave.blade.php view as HTML

        $.ajax({
            url: $api_url,
            method: "GET",
            dataType: "html",
            success: function (response) {
                console.log("✅ Leave details loaded successfully!");
                $("#contentArea").html(response); // Inject response HTML
                closeMobileSidebar(); // Optional: if sidebar is collapsible
            },
            error: function (xhr, status, error) {
                console.error("❌ AJAX Error:", xhr.responseText);
                $("#contentArea").html('<p class="text-red-500">Failed to load Leave Details.</p>');
            }
        });
    }
//salary
function loadSalaryDetails(event) {
    event.preventDefault();
    setActiveLink('salaryLink');
    
    window.API_BASE_URL = "{{ env('MIX_API_URL') }}";
    console.log("API Base URL:", API_BASE_URL);
    
    let $api_url = window.API_BASE_URL + "/admin/salary-details";

    $.ajax({
        url: $api_url,
        method: "GET",
        success: function (response) {
            $('#contentArea').html(response);
            closeMobileSidebar();
        },
        error: function (xhr, status, error) {
            console.error('Error loading salary details:', error);
            $('#contentArea').html('<p class="text-red-500">Failed to load Salary Details.</p>');
        }
    });
}

//rating
function loadEmployeeRating(event) {
    event.preventDefault();
    setActiveLink('ratingLink');
    
    window.API_BASE_URL = "{{ env('MIX_API_URL') }}";
    console.log("API Base URL:", API_BASE_URL);

    let $api_url = window.API_BASE_URL + "/admin/employee-rating";

    $.ajax({
        url: $api_url,
        method: "GET",
        success: function (response) {
            $('#contentArea').html(response);
            closeMobileSidebar();
        },
        error: function (xhr, status, error) {
            console.error('Error loading employee ratings:', error);
            $('#contentArea').html('<p class="text-red-500">Failed to load Employee Ratings.</p>');
        }
    });
}


    </script>
</body>
</html>