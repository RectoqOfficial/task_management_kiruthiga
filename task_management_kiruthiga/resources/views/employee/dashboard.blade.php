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
// function loadMyTasks(event) {
//     event.preventDefault(); // Prevent page reload
//   $("#contentArea").html("<h2 class='text-xl'>My Task</h2><p>Your task details.</p>");
    
// }
function loadMyTasks(event) {
    event.preventDefault(); // Prevent page reload

    $.ajax({
        url: "{{ route('employee.tasks') }}",
        type: "GET",
        success: function(response) {
            $("#contentArea").html(response);
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
}



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
