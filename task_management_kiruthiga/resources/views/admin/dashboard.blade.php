
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex h-screen">

    <!-- Sidebar -->
    <div id="sidebar" class="w-64 bg-gray-900 h-screen p-4 hidden md:block">
        <a class="text-lg font-bold text-white block text-center mb-6" href="#">ADMIN PANEL</a>
        <ul>
        <li class="px-4 py-3">
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
            <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2-2"></path>
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
                <a class="flex items-center text-gray-300 hover:text-purple-400" href="buttons.html">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5"></path>
                    </svg>
                    <span class="ml-4">Scoreboard</span>
                </a>
            </li>
             <!-- Logout Button -->
            <li class="px-4 py-3">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block text-center text-white bg-purple-600 px-4 py-2 rounded-md hover:bg-purple-700">
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
                <a  class="flex items-center text-gray-300 hover:text-purple-400 onclick="loadRoleDetails(event)">Role Details</a>
            </li>
            <li class="px-4 py-3">
                <a class="flex items-center text-gray-300 hover:text-purple-400" onclick="loadEmployeeDetails(event)">Employee Details</a>
            </li>
              <li class="px-4 py-3">
                <a class="flex items-center text-gray-300 hover:text-purple-400" onclick="loadTaskDetails(event)">Task Details</a>
            </li>
            <li class="px-4 py-3">
                <a class="flex items-center text-gray-300 hover:text-purple-400" href="buttons.html">Scoreboard</a>
            </li>
            <li class="px-4 py-3">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block text-center text-white bg-purple-600 px-4 py-2 rounded-md hover:bg-purple-700">
                    Logout
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-900 text-white flex flex-col justify-center items-center">
        <div class="flex items-center w-full justify-between px-4 md:px-0">
            <h1 class="text-2xl font-bold text-center md:text-left w-full">Welcome, you</h1>
        </div>
        
        <p class="mt-2 text-gray-400 text-center">Manage tasks and employees efficiently.</p>

        <!-- Dashboard Overview -->
   <div id="contentArea" class="mt-8 p-8 bg-gray-900 shadow-lg rounded-2xl w-full max-w-4xl text-white">
  
</div>


    </div>

    <script>
        //for sidebar
        function toggleSidebar() {
            let sidebar = document.getElementById('mobileSidebar');
            sidebar.classList.toggle('-translate-x-full');
        }
        //forroledetail
       function loadRoleDetails(event) {
        event.preventDefault(); // Prevents page reload

        fetch("{{ route('admin.role.details') }}") // Fetch content from route
        .then(response => response.text())
        .then(data => {
            document.getElementById('contentArea').innerHTML = data; // Load response into div
        })
        .catch(error => console.error('Error:', error));
    }
    //foremployee
     function loadEmployeeDetails(event) {
        event.preventDefault(); // Prevents page reload

        fetch("{{ route('employees.index') }}") // Fetch content from route
        .then(response => response.text())
        .then(data => {
            document.getElementById('contentArea').innerHTML = data; // Load response into div
        })
        .catch(error => console.error('Error:', error));
    }

   //fortask

  function loadTaskDetails(event) {
    event.preventDefault(); // Prevent full page reload

    $.ajax({
        url: "{{ route('task.details') }}", // Use correct Blade syntax
        type: "GET",
        dataType: "html",
        success: function(response) {
            $("#content-area").html(response); // Load response into content area
        },
        error: function(xhr, status, error) {
            console.error("Error loading Task Details:", error);
            $("#content-area").html("<p class='text-red-500'>Failed to load Task Details.</p>");
        }
    });
}


     </script>

</body>
</html>