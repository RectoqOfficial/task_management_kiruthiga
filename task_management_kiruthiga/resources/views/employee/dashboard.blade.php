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
    <aside class="w-64 bg-blue-900 text-white min-h-screen p-5">
        <h2 class="text-xl font-bold mb-6">Task Management</h2>
        <ul>
            <li class="mb-4">
                <a href="{{ route('employee.tasks') }}" class="block py-2 px-4 bg-blue-700 rounded-lg hover:bg-blue-600">
                    My Task
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('employee.profile') }}" class="block py-2 px-4 bg-blue-700 rounded-lg hover:bg-blue-600">
                    Profile
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('employee.score') }}" class="block py-2 px-4 bg-blue-700 rounded-lg hover:bg-blue-600">
                    View Score
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                   class="block py-2 px-4 bg-red-600 rounded-lg hover:bg-red-500">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ Auth::user()->fullname }}</h1>
        <p class="text-gray-600 mt-2">View and manage your assigned tasks.</p>
    </main>
</body>
</html>
