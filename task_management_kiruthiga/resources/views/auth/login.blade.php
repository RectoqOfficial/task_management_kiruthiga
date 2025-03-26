<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Task Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full text-center">
        <h2 class="text-2xl font-bold text-gray-800">Login</h2>
        
        <!-- Error Message Display -->
        <p id="error-message" class="text-red-500 text-sm font-semibold hidden"></p>

        <form id="loginForm" action="{{ route('login.post') }}" method="POST" class="mt-6">
            @csrf
            <div class="mb-4">
                <input type="email" id="email" name="email" placeholder="Enter Email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                <input type="password" id="password" name="password" placeholder="Enter Password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            <button type="submit" class="w-full px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 transition">Login</button>
        </form>
    </div>

    <!-- JavaScript for Validation -->
    <script>
        document.getElementById("loginForm").addEventListener("submit", function(event) {
            var email = document.getElementById("email").value.trim();
            var password = document.getElementById("password").value.trim();
            var errorMessage = document.getElementById("error-message");

            if (email === "" && password === "") {
                errorMessage.textContent = "Please enter both Email and Password.";
                errorMessage.classList.remove("hidden");
                event.preventDefault();
            } else if (email === "") {
                errorMessage.textContent = "Please enter your Email ID.";
                errorMessage.classList.remove("hidden");
                event.preventDefault();
            } else if (password === "") {
                errorMessage.textContent = "Please enter your Password.";
                errorMessage.classList.remove("hidden");
                event.preventDefault();
            } else {
                errorMessage.classList.add("hidden"); // Hide error message if both fields are filled
            }
        });
    </script>
</body>
</html>
