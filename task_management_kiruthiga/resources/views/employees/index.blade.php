<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-bold text-gray-800 my-6 text-center sm:text-left">Employee Details</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 p-3 text-green-800 bg-green-100 border border-green-300 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Employee Details Heading and Add Employee Button -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Employee Details</h2>
        <a href="{{ route('employees.create') }}" class="mt-2 sm:mt-0 px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-all">
            Add Employee
        </a>
    </div>

    <!-- Responsive Table -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-900 text-white">
                <tr class="text-left text-xs sm:text-sm md:text-base">
                    <th class="px-4 py-3">Full Name</th>
                    <th class="px-4 py-3">Gender</th>
                    <th class="px-4 py-3">Date of Joining</th>
                    <th class="px-4 py-3">Contact</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Department</th>
                    <th class="px-4 py-3">Designation</th>
                    <th class="px-4 py-3">Job Type</th>
                    <th class="px-4 py-3">Role</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-xs sm:text-sm md:text-base">
                @foreach($employees as $employee)
                <tr class="border-b hover:bg-gray-100 transition-all">
                    <td class="px-4 py-3 whitespace-nowrap">{{ $employee->fullname }}</td>
                    <td class="px-4 py-3">{{ $employee->gender }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $employee->date_of_joining }}</td>
                    <td class="px-4 py-3">{{ $employee->contact }}</td>
                    <td class="px-4 py-3">{{ $employee->email_id }}</td>
                    <td class="px-4 py-3">{{ $employee->department }}</td>
                    <td class="px-4 py-3">{{ $employee->designation }}</td>
                    <td class="px-4 py-3">{{ $employee->jobtype }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        {{ $employee->role ? $employee->role->name : 'No Role Assigned' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-center">
        {{ $employees->links() }}
    </div>
</div>
@endsection
