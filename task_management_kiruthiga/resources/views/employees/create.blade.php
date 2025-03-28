<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

@extends('layouts.app')

@section('content')
<div class="max-w-md sm:max-w-2xl mx-auto mt-10 bg-white p-6 sm:p-8 shadow-xl rounded-lg border border-gray-200">
    <h2 class="text-2xl sm:text-3xl font-extrabold text-center text-gray-800 mb-6">Add Employee</h2>

    @if(session('success'))
        <div class="mb-4 p-3 text-green-800 bg-green-100 border border-green-300 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 text-red-800 bg-red-100 border border-red-300 rounded-lg shadow-sm">
            <ul>
                @foreach($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employees.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold text-gray-700">Full Name</label>
                <input type="text" name="fullname" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 transition shadow-sm" required>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Gender</label>
                <select name="gender" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 transition shadow-sm" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="others">others</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Date of Joining</label>
                <input type="date" name="date_of_joining" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 transition shadow-sm" required>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Contact</label>
                <input type="text" name="contact" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 transition shadow-sm" required>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Email</label>
                <input type="email" name="email_id" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 transition shadow-sm" required>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Password</label>
                <input type="password" name="password" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 transition shadow-sm" required>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Department</label>
                <select name="department" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 transition shadow-sm" required>
                    <option value="">Select Department</option>
                    @foreach($roleDetails as $role)
                        <option value="{{ $role->department }}">{{ $role->department }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Designation</label>
                <select name="designation" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 transition shadow-sm" required>
                    <option value="">Select Designation</option>
                    @foreach($roleDetails as $role)
                        <option value="{{ $role->role }}">{{ $role->role }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Job Type</label>
                <select name="jobtype" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 transition shadow-sm" required>
                    <option value="">Select Job Type</option>
                    <option value="Onsite">Onsite</option>
                    <option value="Remote">Remote</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Role</label>
                <select name="role_id" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 transition shadow-sm" required>
                    <option value="">Select Role</option>
                    @foreach($roleDetails as $role)
                        <option value="{{ $role->id }}">{{ $role->id }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit" class="w-full p-3 mt-4 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition-all duration-300 ease-in-out shadow-md">
            Save Employee
        </button>
    </form>
</div>
@endsection
