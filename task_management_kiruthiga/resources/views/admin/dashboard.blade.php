<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-900 text-white h-screen p-6">
            <h2 class="text-xl font-bold">Admin Dashboard</h2>
            <ul class="mt-6 space-y-4">
                <li><a href="{{ route('admin.role.details') }}" class="block hover:text-gray-300">Role Details</a></li>
                <li><a href="{{ route('admin.employee.details') }}" class="block hover:text-gray-300">Employee Details</a></li>
                <li><a href="{{ route('admin.task.details') }}" class="block hover:text-gray-300">Task Details</a></li>
                <li><a href="{{ route('admin.scoreboard') }}" class="block hover:text-gray-300">Scoreboard</a></li>
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
            <p>This is the admin dashboard.</p>
        </div>
    </div>

   
</body>
</html>
