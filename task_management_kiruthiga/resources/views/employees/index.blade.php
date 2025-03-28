<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-bold text-gray-800 my-6">Employee Details</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 p-3 text-green-800 bg-green-100 border border-green-300 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add Employee Button -->
    <div class="flex justify-end mb-4">
        <a href="{{ route('employees.create') }}" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all">
            Add Employee
        </a>
    </div>

    <!-- Responsive Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-4 py-3 text-left">Full Name</th>
                    <th class="px-4 py-3 text-left">Gender</th>
                    <th class="px-4 py-3 text-left">Date of Joining</th>
                    <th class="px-4 py-3 text-left">Contact</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Department</th>
                    <th class="px-4 py-3 text-left">Designation</th>
                    <th class="px-4 py-3 text-left">Job Type</th>
                    <th class="px-4 py-3 text-left">Role</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($employees as $employee)
                <tr class="border-b hover:bg-gray-100 transition-all">
                    <td class="px-4 py-3">{{ $employee->fullname }}</td>
                    <td class="px-4 py-3">{{ $employee->gender }}</td>
                    <td class="px-4 py-3">{{ $employee->date_of_joining }}</td>
                    <td class="px-4 py-3">{{ $employee->contact }}</td>
                    <td class="px-4 py-3">{{ $employee->email_id }}</td>
                    <td class="px-4 py-3">{{ $employee->department }}</td>
                    <td class="px-4 py-3">{{ $employee->designation }}</td>
                    <td class="px-4 py-3">{{ $employee->jobtype }}</td>
                    <td class="px-4 py-3">{{ $employee->role ? $employee->role->name : 'No Role Assigned' }}</td>
    

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
