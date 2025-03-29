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
<div class="container mx-auto p-6 bg-gray-900 min-h-screen">
    <h2 class="text-3xl font-bold mb-6 text-center text-white">Role Details</h2>

    <!-- Role Detail Form -->
    <form id="roleDetailForm" class="mb-6 bg-gray-800 p-6 rounded-lg shadow-md">
        <div class="space-y-4">
            <div>
                <label for="role" class="block text-sm text-white">Role</label>
                <input type="text" id="role" name="role" class="w-full px-4 py-2 border border-gray-700 rounded-lg bg-gray-900 text-white focus:ring-2 focus:ring-purple-500" required>
            </div>
            <div>
                <label for="department" class="block text-sm text-white">Department</label>
                <input type="text" id="department" name="department" class="w-full px-4 py-2 border border-gray-700 rounded-lg bg-gray-900 text-white focus:ring-2 focus:ring-purple-500" required>
           <div class="flex justify-center">
    <button type="submit" class="w-full md:w-1/2 bg-violet-500 m-2 text-white px-6 py-2 rounded-md hover:bg-violet-600 transition duration-300">
        Add Role
    </button>
</div>

    </form>

    <!-- Role Table with horizontal scrolling and responsiveness -->
    <div class="overflow-x-auto mt-6">
        <table class="min-w-full table-auto border-collapse bg-gray-800 rounded-lg shadow-md">
            <thead>
                <tr class="text-white">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Role</th>
                    <th class="border px-4 py-2">Department</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody id="roleTableBody">
                @foreach($roles as $role)
                <tr id="role_{{ $role->id }}" class="text-white hover:bg-gray-700 transition duration-300">
                    <td class="border px-4 py-2">{{ $role->id }}</td>
                    <td class="border px-4 py-2">{{ $role->role }}</td>
                    <td class="border px-4 py-2">{{ $role->department }}</td>
                    <td class="border px-4 py-2">
                        {{-- <button onclick="editRole({{ $role->id }})" class="bg-yellow-500 text-white px-4 py-1 rounded-md hover:bg-yellow-600 transition duration-300">Edit</button> --}}
                        <button onclick="deleteRole({{ $role->id }})" class="bg-red-500 text-white px-4 py-1 rounded-md hover:bg-red-600 transition duration-300">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Script to handle AJAX requests -->
<script>
    // Add new role
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
            body: JSON.stringify({
                role: role,
                department: department
            })
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

    // Delete role
    function deleteRole(id) {
        fetch(`/roles/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`role_${id}`).remove();
            }
        })
        .catch(error => console.log(error));
    }

    // Edit role function (to be implemented)
    function editRole(id) {
        alert('Edit functionality not yet implemented');
    }
</script>
@endsection

</html>
