<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Task Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-lg text-center">
        <h1 class="text-3xl font-bold text-gray-800">Welcome to Task Management App</h1>
        <p class="mt-4 text-gray-600">Manage your tasks efficiently with ease.</p>
        <a href="{{ route('login') }}" class="mt-6 inline-block px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 transition">
            Login
        </a>
    </div>
</body>
</html>
