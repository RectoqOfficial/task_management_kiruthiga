<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-gray-900 p-6 sm:p-8 shadow-xl rounded-lg border border-gray-700 text-white">
    <h2 class="text-2xl sm:text-3xl font-extrabold text-center text-white mb-6">Add Employee</h2>

    @if(session('success'))
        <div class="mb-4 p-3 text-green-300 bg-green-900 border border-green-600 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 text-red-300 bg-red-900 border border-red-600 rounded-lg shadow-sm">
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
                <label class="block font-semibold text-gray-300">Full Name</label>
                <input type="text" name="fullname" class="w-full p-3 border border-gray-700 bg-gray-800 rounded-lg focus:ring-2 focus:ring-purple-500 text-white" required>
            </div>

            <div>
                <label class="block font-semibold text-gray-300">Gender</label>
                <select name="gender" class="w-full p-3 border border-gray-700 bg-gray-800 rounded-lg focus:ring-2 focus:ring-purple-500 text-white" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="others">Others</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold text-gray-300">Date of Joining</label>
                <input type="date" name="date_of_joining" class="w-full p-3 border border-gray-700 bg-gray-800 rounded-lg focus:ring-2 focus:ring-purple-500 text-white" required>
            </div>

            <div>
                <label class="block font-semibold text-gray-300">Contact</label>
                <input type="text" name="contact" class="w-full p-3 border border-gray-700 bg-gray-800 rounded-lg focus:ring-2 focus:ring-purple-500 text-white" required>
            </div>

            <div>
                <label class="block font-semibold text-gray-300">Email</label>
                <input type="email" name="email_id" class="w-full p-3 border border-gray-700 bg-gray-800 rounded-lg focus:ring-2 focus:ring-purple-500 text-white" required>
            </div>

            <div>
                <label class="block font-semibold text-gray-300">Password</label>
                <input type="password" name="password" class="w-full p-3 border border-gray-700 bg-gray-800 rounded-lg focus:ring-2 focus:ring-purple-500 text-white" required>
            </div>

            <div>
                <label class="block font-semibold text-gray-300">Department</label>
                <select name="department" class="w-full p-3 border border-gray-700 bg-gray-800 rounded-lg focus:ring-2 focus:ring-purple-500 text-white" required>
                    <option value="">Select Department</option>
                    @foreach($roleDetails as $role)
                        <option value="{{ $role->department }}">{{ $role->department }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold text-gray-300">Designation</label>
                <select name="designation" class="w-full p-3 border border-gray-700 bg-gray-800 rounded-lg focus:ring-2 focus:ring-purple-500 text-white" required>
                    <option value="">Select Designation</option>
                    @foreach($roleDetails as $role)
                        <option value="{{ $role->role }}">{{ $role->role }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold text-gray-300">Job Type</label>
                <select name="job_type" class="w-full p-3 border border-gray-700 bg-gray-800 rounded-lg focus:ring-2 focus:ring-purple-500 text-white" required>
                    <option value="">Select Job Type</option>
                    <option value="Onsite">Onsite</option>
                    <option value="Remote">Remote</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold text-gray-300">Role</label>
                <select name="role_id" class="w-full p-3 border border-gray-700 bg-gray-800 rounded-lg focus:ring-2 focus:ring-purple-500 text-white" required>
                    <option value="">Select Role</option>
                    @foreach($roleDetails as $role)
                        <option value="{{ $role->id }}">{{ $role->role }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit" class="w-full p-3 mt-4 bg-purple-600 text-white font-bold rounded-lg hover:bg-purple-700 transition-all duration-300 ease-in-out shadow-md">
            Save Employee
        </button>
    </form>
</div>
@endsection
