<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Details</title>
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
        <h1 class="text-3xl font-bold text-gray-800">Role Details</h1>

        <!-- Button to add a new role -->
        <div class="mt-4 mb-6">
            <a href="{{ route('admin.role.add') }}" class="bg-blue-500 text-white py-2 px-4 rounded">Add Role</a>
        </div>

        <!-- Role Table -->
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Role</th>
                    <th class="py-3 px-6 text-left">Department</th>
                  
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr class="border-b border-gray-300">
                        <td class="py-3 px-6">{{ $role->id }}</td>
                        <td class="py-3 px-6">{{ $role->name }}</td>
                        <td class="py-3 px-6">{{ $role->department }}</td>
                       
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
