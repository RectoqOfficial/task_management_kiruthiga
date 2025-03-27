<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-green-900 text-white h-screen p-6">
            <h2 class="text-xl font-bold">Employee Dashboard</h2>
            <ul class="mt-6 space-y-4">
                <li><a href="#" class="block hover:text-gray-300">My Tasks</a></li>
                <li><a href="#" class="block hover:text-gray-300">Profile</a></li>
                <li><a href="#" class="block hover:text-gray-300">Scoreboard</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left">Logout</button>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <h1 class="text-2xl font-bold">Welcome, {{ Auth::user()->fullname }}</h1>
            <p>This is the employee dashboard.</p>
        </div>
    </div>
</body>
</html>
