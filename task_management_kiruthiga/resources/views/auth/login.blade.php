<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Task Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 bg-gradient-to-r from-gray-800 via-gray-700 to-gray-900 animate-gradient-x">

    <div class="bg-gray-800 shadow-2xl rounded-lg p-6 sm:p-8 w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg text-center transform transition duration-300 hover:scale-105">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-white mb-4">Login</h2>

        <!-- Laravel Error Message Display -->
        @if (session('error'))
            <p class="text-red-500 text-sm font-semibold mt-2 animate-pulse">{{ session('error') }}</p>
        @endif

       <form id="loginForm" action="{{ route('login.post') }}" method="POST" class="mt-4 sm:mt-6">
    @csrf

    <!-- User Type Selector -->
    <div class="mb-3 sm:mb-4 text-left">
        <select id="user_type" name="user_type"
                class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition duration-200" required>
            <option value="">Select Login As</option>
            <option value="admin">Admin</option>
            <option value="employee">Employee</option>
        </select>
        <p id="userTypeError" class="text-red-500 text-xs mt-1 hidden">Please select a login type.</p>
    </div>

    <!-- Email -->
    <div class="mb-3 sm:mb-4 text-left">
        <input type="email" id="email" name="email" placeholder="Enter Email" 
               class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition duration-200" required>
        <p id="emailError" class="text-red-500 text-xs mt-1 hidden">Email is required.</p>
    </div>

    <!-- Password -->
    <div class="mb-3 sm:mb-4 text-left">
        <input type="password" id="password" name="password" placeholder="Enter Password" 
               class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition duration-200" required>
        <p id="passwordError" class="text-red-500 text-xs mt-1 hidden">Password is required.</p>
    </div>

    <!-- Submit -->
    <button type="submit" 
            class="w-full px-5 py-2 sm:py-3 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
        Login
    </button>
</form>

    </div>

    <!-- JavaScript for Improved Validation -->
    <script>
        document.getElementById("loginForm").addEventListener("submit", function(event) {
            var email = document.getElementById("email");
            var password = document.getElementById("password");
            var emailError = document.getElementById("emailError");
            var passwordError = document.getElementById("passwordError");
            let valid = true;

            if (email.value.trim() === "") {
                emailError.classList.remove("hidden");
                valid = false;
            } else {
                emailError.classList.add("hidden");
            }

            if (password.value.trim() === "") {
                passwordError.classList.remove("hidden");
                valid = false;
            } else {
                passwordError.classList.add("hidden");
            }

            if (!valid) event.preventDefault();
        });
    </script>

</body>
</html>