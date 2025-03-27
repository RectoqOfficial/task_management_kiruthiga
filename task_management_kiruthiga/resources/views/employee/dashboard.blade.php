<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-800">Welcome, Employee</h1>
        <p class="text-gray-600 mt-2">View and manage your assigned tasks.</p>
        <a href="{{ route('logout') }}" 
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
            class="mt-4 inline-block px-6 py-3 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-600 transition">
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</body>
</html>
