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
        <input type="email" id="email" name="email" placeholder="Enter your Email" 
               class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition duration-200" required>
        <p id="emailError" class="text-red-500 text-xs mt-1 hidden">Email is required.</p>
    </div>

  
  <!-- Password -->
<div class="mb-3 sm:mb-4 text-left relative">
    <input type="password" id="password" name="password" placeholder="Enter your  Password" 
           class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition duration-200 pr-10" required>
    
    <!-- Eye Icon -->
    <button type="button" onclick="togglePassword()" 
            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-300 hover:text-white focus:outline-none">
        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" 
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
    </button>

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

        //password eye option
         function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';

        // Optional: Change the eye icon (you can swap to eye-off here if you want)
        eyeIcon.innerHTML = isPassword
            ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.973 9.973 0 012.242-3.528m1.405-1.405A9.965 9.965 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.182 5.208M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />`
            : `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
    }
    </script>

</body>
</html>