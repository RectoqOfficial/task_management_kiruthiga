<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Role</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">
    <!-- Sidebar -->
    <div class="w-64 bg-gray-800 h-screen p-6 text-white">
        <h2 class="text-2xl font-bold mb-6">Admin Panel</h2>
        <ul>
            <li class="mb-4"><a href="{{ route('admin.role.details') }}" class="hover:text-gray-400">Role Details</a></li>
            <li class="mb-4"><a href="#" class="hover:text-gray-400">Employee Details</a></li>
            <li class="mb-4"><a href="#" class="hover:text-gray-400">Task Details</a></li>
            <li class="mb-4"><a href="#" class="hover:text-gray-400">Scoreboard</a></li>
            <li><a href="{{ route('admin.logout') }}" class="hover:text-gray-400">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <h1 class="text-3xl font-bold text-gray-800">Add Role</h1>

        <!-- Role Form -->
        <form action="{{ route('admin.role.store') }}" method="POST" class="mt-6">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Role Name</label>
                <input type="text" id="name" name="name" class="w-full p-3 border border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label for="department" class="block text-gray-700">Department</label>
                <input type="text" id="department" name="department" class="w-full p-3 border border-gray-300 rounded" required>
            </div>

            <div>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Add Role</button>
            </div>
        </form>
    </div>
</body>
</html>
