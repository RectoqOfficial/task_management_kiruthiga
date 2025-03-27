<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">
    <!-- Sidebar -->
    <div class="w-64 bg-gray-800 h-screen p-5 text-white">
        <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>
        <ul>
            <li class="mb-4"><a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Role Details</a></li>
            <li class="mb-4"><a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Employee Details</a></li>
            <li class="mb-4"><a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Task Details</a></li>
            <li class="mb-4"><a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Scoreboard</a></li>
            <li class="mb-4">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 bg-red-500 rounded hover:bg-red-600">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="flex-1 p-6">
        <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ auth()->user()->full_name }}</h1>
        <p class="text-gray-600 mt-2">Manage tasks and employees efficiently.</p>
    </div>
</body>
</html>
