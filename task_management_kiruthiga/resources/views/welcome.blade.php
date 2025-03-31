<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Task Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black flex items-center justify-center min-h-screen p-4">

    <div class="bg-gray-800 shadow-lg rounded-lg p-6 sm:p-8 lg:p-10 w-full max-w-sm sm:max-w-md md:max-w-lg lg:max-w-xl text-center">
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white">Welcome to Task Management App</h1>
        <p class="mt-2 sm:mt-4 text-gray-300 text-sm sm:text-base">
            Manage your tasks efficiently with ease.
        </p>
        
        <a href="{{ route('login') }}" 
           class="mt-4 sm:mt-6 inline-block px-5 sm:px-6 py-2 sm:py-3 bg-[#ff0003] text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition">
            Login
        </a>
    </div>

</body>
</html>
