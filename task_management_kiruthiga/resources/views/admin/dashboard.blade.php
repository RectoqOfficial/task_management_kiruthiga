<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-blue-900 text-white p-6">
        <h2 class="text-xl font-bold mb-4">Admin Panel</h2>
        <ul>
            <li><a href="#" class="block py-2 hover:bg-blue-700">Role Details</a></li>
            <li><a href="#" class="block py-2 hover:bg-blue-700">Employee Details</a></li>
            <li><a href="#" class="block py-2 hover:bg-blue-700">Task Details</a></li>
            <li><a href="#" class="block py-2 hover:bg-blue-700">Score Board</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full text-left py-2 hover:bg-red-700">Logout</button>
                </form>
            </li>
        </ul>
    </aside>

    <!-- Content -->
    <main class="flex-1 p-10">
        <h1 class="text-3xl font-bold">Welcome, {{ $user->name }}</h1>
        <p class="text-gray-700 mt-2">This is the Admin Dashboard.</p>
    </main>
</body>
</html>
