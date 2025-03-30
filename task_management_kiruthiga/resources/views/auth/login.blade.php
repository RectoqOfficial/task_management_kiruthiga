<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Task Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black flex items-center justify-center min-h-screen p-4">

    <div class="bg-gray-800 shadow-lg rounded-lg p-6 sm:p-8 w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg text-center">
        <h2 class="text-2xl sm:text-3xl font-bold text-white">Login</h2>

        <!-- Laravel Error Message Display -->
        @if (session('error'))
            <p class="text-red-500 text-sm font-semibold mt-2">{{ session('error') }}</p>
        @endif

        <form id="loginForm" action="{{ route('login.post') }}" method="POST" class="mt-4 sm:mt-6">
            @csrf
            <div class="mb-3 sm:mb-4 text-left">
                <input type="email" id="email" name="email" placeholder="Enter Email" 
                       class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-red-500" required>
                <p id="emailError" class="text-red-500 text-xs mt-1 hidden">Email is required.</p>
            </div>

            <div class="mb-3 sm:mb-4 text-left">
                <input type="password" id="password" name="password" placeholder="Enter Password" 
                       class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-red-500" required>
                <p id="passwordError" class="text-red-500 text-xs mt-1 hidden">Password is required.</p>
            </div>

            <button type="submit" 
                    class="w-full px-5 py-2 sm:py-3 bg-[#ff0003] text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition">
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