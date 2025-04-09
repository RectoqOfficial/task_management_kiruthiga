<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Task Management App - Organize, assign, and track your tasks efficiently with a clean and responsive interface.">
    <meta name="keywords" content="Task Management, Productivity, Laravel, Project Tracking, Team Collaboration, To-do List">
    <meta name="author" content="kiruthi">
    <title>Welcome | Task Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen p-4 bg-gradient-to-r from-gray-800 via-gray-700 to-gray-900 animate-gradient-x">

    <div class="bg-gray-800 shadow-2xl rounded-lg p-6 sm:p-8 lg:p-10 w-full max-w-sm sm:max-w-md md:max-w-lg lg:max-w-xl text-center transform hover:scale-105 transition-transform duration-300">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white">
            Welcome to <span class="text-red-500">Task Management App</span>
        </h1>
        <p class="mt-4 sm:mt-6 text-gray-300 text-base sm:text-lg">
            Manage your tasks efficiently and stay organized with ease.
        </p>
        
        <a href="{{ route('login') }}" 
           class="mt-6 sm:mt-8 inline-block px-6 sm:px-8 py-3 sm:py-4 bg-red-500 text-white font-semibold rounded-full shadow-lg hover:bg-red-600 hover:shadow-xl transition-all duration-300">
            Login
        </a>
    </div>

</body>
</html>
