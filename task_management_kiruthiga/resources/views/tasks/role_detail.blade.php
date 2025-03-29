<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Detail | Task Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
 

</head>

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-gray-900 min-h-screen ">
    <h2 class="text-3xl font-bold mb-6 text-center  text-white">Role Details</h2>

<!-- Role Detail Form -->
<form id="roleDetailForm" class="group mb-6 p-6 rounded-lg shadow-xl bg-gradient-to-br from-gray-800 to-gray-900 bg-opacity-60 backdrop-blur-lg max-w-lg mx-auto transition duration-500 hover:ring-4 hover:ring-purple-500/50">
    <div class="space-y-4">
        <div>
            <label for="role" class="block text-sm text-white">Role</label>
            <input type="text" id="role" name="role" class="w-full px-4 py-2 border border-gray-700 rounded-lg bg-gray-900 text-white focus:ring-2 focus:ring-purple-500 transition duration-300 hover:border-purple-400">
        </div>
        <div>
            <label for="department" class="block text-sm text-white">Department</label>
            <input type="text" id="department" name="department" class="w-full px-4 py-2 border border-gray-700 rounded-lg bg-gray-900 text-white focus:ring-2 focus:ring-purple-500 transition duration-300 hover:border-purple-400">
        </div>
        <div class="flex justify-center">
            <button type="submit" class="w-full md:w-1/2 bg-violet-500 m-2 text-white px-6 py-2 rounded-md hover:bg-violet-600 hover:shadow-lg hover:shadow-purple-500 transition duration-300">
                Add Role
            </button>
        </div>
    </div>
</form>


<!-- Role Table -->
<div class="overflow-x-auto mt-6">
    <table class="w-full border-collapse bg-gradient-to-br from-gray-800 to-gray-900 bg-opacity-60 backdrop-blur-lg rounded-lg shadow-lg text-sm md:text-base">
        <thead>
            <tr class="text-white bg-purple-700/60">
                <th class="px-4 py-3 text-left border-b border-gray-700">ID</th>
                <th class="px-4 py-3 text-left border-b border-gray-700">Role</th>
                <th class="px-4 py-3 text-left border-b border-gray-700">Department</th>
                <th class="px-4 py-3 text-left border-b border-gray-700">Actions</th>
            </tr>
        </thead>
        <tbody id="roleTableBody">
            @foreach($roles as $role)
            <tr id="role_{{ $role->id }}" class="text-white hover:bg-purple-600/30 hover:ring-2 hover:ring-purple-500/50 transition duration-300 ease-in-out">
                <td class="px-4 py-3 border-b border-gray-700">{{ $role->id }}</td>
                <td class="px-4 py-3 border-b border-gray-700">{{ $role->role }}</td>
                <td class="px-4 py-3 border-b border-gray-700">{{ $role->department }}</td>
                <td class="px-4 py-3 border-b border-gray-700">
                    <button onclick="deleteRole({{ $role->id }})" class="bg-red-500 text-white px-4 py-1 rounded-md hover:bg-red-600 shadow-md hover:shadow-red-500/50 transition duration-300">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<!-- Script for AJAX requests -->
<script>
    document.getElementById('roleDetailForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const role = document.getElementById('role').value;
        const department = document.getElementById('department').value;

        fetch("{{ route('role_details.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ role, department })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const role = data.role;
                const newRow = `<tr id="role_${role.id}" class="text-white hover:bg-gray-700 transition duration-300">
                    <td class="border px-4 py-2">${role.id}</td>
                    <td class="border px-4 py-2">${role.role}</td>
                    <td class="border px-4 py-2">${role.department}</td>
                    <td class="border px-4 py-2">
                        <button onclick="deleteRole(${role.id})" class="bg-red-500 text-white px-4 py-1 rounded-md hover:bg-red-600 transition duration-300">Delete</button>
                    </td>
                </tr>`;
                document.getElementById('roleTableBody').innerHTML += newRow;
                document.getElementById('roleDetailForm').reset();
            }
        })
        .catch(error => console.log(error));
    });

    function deleteRole(id) {
        fetch(`/roles/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`role_${id}`).remove();
            }
        })
        .catch(error => console.log(error));
    }
</script>
@endsection
</html>