<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg overflow-hidden mt-10 sm:max-w-lg md:max-w-2xl lg:max-w-4xl hover:shadow-2xl hover:scale-105 transition-transform duration-300 cursor-pointer">
        <div class="px-6 py-4 bg-[#ff0003] text-white text-center text-xl font-semibold">
            Employee Profile
        </div>
        <div class="p-6 space-y-4">
            <div class="bg-gray-50 p-4 rounded-lg shadow-md hover:bg-gray-100 transition-colors duration-300 cursor-pointer">
                <p class="text-gray-700"><span class="font-medium">Name:</span> {{ $employee->full_name }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg shadow-md hover:bg-gray-100 transition-colors duration-300 cursor-pointer">
                <p class="text-gray-700"><span class="font-medium">Email:</span> {{ $employee->email_id }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg shadow-md hover:bg-gray-100 transition-colors duration-300 cursor-pointer">
                <p class="text-gray-700"><span class="font-medium">Gender:</span> {{ $employee->gender }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg shadow-md hover:bg-gray-100 transition-colors duration-300 cursor-pointer">
                <p class="text-gray-700"><span class="font-medium">Contact:</span> {{ $employee->contact }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg shadow-md hover:bg-gray-100 transition-colors duration-300 cursor-pointer">
                <p class="text-gray-700"><span class="font-medium">Department:</span> {{ $employee->department->name }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg shadow-md hover:bg-gray-100 transition-colors duration-300 cursor-pointer">
                <p class="text-gray-700"><span class="font-medium">Role:</span> {{ $employee->role->name }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg shadow-md hover:bg-gray-100 transition-colors duration-300 cursor-pointer">
                <p class="text-gray-700"><span class="font-medium">Date of Joining:</span> {{ $employee->date_of_joining }}</p>
            </div>
        </div>
    </div>
</body>
