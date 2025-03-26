<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">
    <!-- Sidebar -->
    <div class="w-64 bg-gray-800 h-screen p-6 text-white">
        <h2 class="text-2xl font-bold mb-6">Employee Panel</h2>
        <ul>
            <li class="mb-4"><a href="#" class="hover:text-gray-400">My Tasks</a></li>
            <li class="mb-4"><a href="#" class="hover:text-gray-400">Profile</a></li>
            <li class="mb-4"><a href="#" class="hover:text-gray-400">View Score</a></li>
            <li><a href="{{ route('logout') }}" class="hover:text-gray-400">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ $user->full_name }}</h1>
        <p class="mt-4 text-gray-600">This is the Employee Dashboard.</p>
    </div>
</body>
</html>
