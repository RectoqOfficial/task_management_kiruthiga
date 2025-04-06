<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @keyframes colorChange {
            0% { color: red; }
            50% { color: blue; }
            100% { color: green; }
        }

        .animate-color {
            animation: colorChange 3s infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-r from-blue-500 to-purple-600 min-h-screen flex items-center justify-center">
    <div class="max-w-4xl mx-auto bg-white shadow-2xl rounded-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
        <div class="px-6 py-4 bg-gradient-to-r from-red-500 to-pink-500 text-white text-center text-2xl font-bold uppercase tracking-wide">
            Employee Profile
        </div>
        <div class="p-8 space-y-6">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold text-xl animate-color">
                    {{ substr($employee->full_name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800">{{ $employee->full_name }}</h2>
                    <p class="text-gray-500">{{ $employee->role->name }}</p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:bg-gray-100 transition-colors duration-300">
                    <p class="text-gray-700"><span class="font-medium">Email:</span> {{ $employee->email_id }}</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:bg-gray-100 transition-colors duration-300">
                    <p class="text-gray-700"><span class="font-medium">Gender:</span> {{ $employee->gender }}</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:bg-gray-100 transition-colors duration-300">
                    <p class="text-gray-700"><span class="font-medium">Contact:</span> {{ $employee->contact }}</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:bg-gray-100 transition-colors duration-300">
                    <p class="text-gray-700"><span class="font-medium">Department:</span> {{ $employee->department->name }}</p>
                </div>
				 <div class="bg-gray-50 p-4 rounded-lg shadow-md hover:bg-gray-100 transition-colors duration-300 cursor-pointer">
                <p class="text-gray-700 break-words"><span class="font-medium">Role:</span> {{ $employee->role->name }}</p>
            </div>
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:bg-gray-100 transition-colors duration-300">
                    <p class="text-gray-700"><span class="font-medium">Date of Joining:</span> {{ $employee->date_of_joining }}</p>
                </div>
            </div>
        </div>
       
    </div>
</body>
</html>
