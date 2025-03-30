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
<div class="container mx-auto p-6 bg-black min-h-screen">
    <h2 class="text-3xl font-bold mb-6 text-center text-white">Role Details</h2>

    <!-- Role Detail Form -->
    <form id="roleDetailForm" class="group mb-6 p-6 rounded-lg shadow-xl bg-gray-900 max-w-lg mx-auto">
        <div class="space-y-4">
            <div>
                <label for="role" class="block text-sm text-white">Role</label>
                <input type="text" id="role" name="role" class="w-full px-3 py-2 border border-gray-700 bg-gray-900 rounded-lg text-white focus:ring-2 focus:ring-red-500" required>
            </div>
            <div>
                <label for="department" class="block text-sm text-white">Department</label>
                <input type="text" id="department" name="department" class="w-full px-3 py-2 border border-gray-700 bg-gray-900 rounded-lg text-white focus:ring-2 focus:ring-red-500" required>
            </div>
            <div class="flex justify-center">
                <button type="submit" class="w-full md:w-1/2 bg-[#ff0003] m-2 text-white px-6 py-2 rounded-md hover:opacity-80 transition duration-300">
                    Add Role
                </button>
            </div>
        </div>
    </form>

    <!-- Role Table -->
    <div class="overflow-x-auto mt-6">
        <table class="w-full border-collapse bg-gray-900 rounded-lg shadow-lg text-sm md:text-base">
            <thead>
                <tr class="text-white bg-[#ff0003]
">
                    <th class="px-4 py-3 text-left border-b border-gray-700">ID</th>
                    <th class="px-4 py-3 text-left border-b border-gray-700">Role</th>
                    <th class="px-4 py-3 text-left border-b border-gray-700">Department</th>
                    <th class="px-4 py-3 text-left border-b border-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody id="roleTableBody">
                @foreach($roles as $role)
                <tr id="role_{{ $role->id }}" class="text-white hover:bg-gray-700 transition duration-300">
                    <td class="px-4 py-3 border-b border-gray-700">{{ $role->id }}</td>
                    <td class="px-4 py-3 border-b border-gray-700">{{ $role->role }}</td>
                    <td class="px-4 py-3 border-b border-gray-700">{{ $role->department }}</td>
                    <td class="px-4 py-3 border-b border-gray-700">
                        <button onclick="deleteRole({{ $role->id }})" class="bg-[#ff0003] text-white px-4 py-1 rounded-md hover:opacity-80 transition duration-300">Delete</button>
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
            const newRow = `
                <tr id="role_${data.role.id}" class="text-white hover:bg-gray-700 transition duration-300">
                    <td class="px-4 py-3 border-b border-gray-700">${data.role.id}</td>
                    <td class="px-4 py-3 border-b border-gray-700">${data.role.role}</td>
                    <td class="px-4 py-3 border-b border-gray-700">${data.role.department}</td>
                    <td class="px-4 py-3 border-b border-gray-700">
                        <button onclick="deleteRole(${data.role.id})" class="bg-[#ff0003] text-white px-4 py-1 rounded-md hover:opacity-80 transition duration-300">Delete</button>
                    </td>
                </tr>`;
            document.getElementById('roleTableBody').insertAdjacentHTML('beforeend', newRow);
            document.getElementById('roleDetailForm').reset();
        } else {
            alert(data.message); // Show error message if duplicate role is added
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


        // Function to update role dropdown based on department selection
document.getElementById('department').addEventListener('change', function () {
    const selectedDepartment = this.value;
    const roleSelect = document.getElementById('role');
    roleSelect.innerHTML = ""; // Clear previous options

    roleOptions[selectedDepartment].forEach(role => {
        let option = document.createElement('option');
        option.value = role;
        option.textContent = role;
        roleSelect.appendChild(option);
    });
});

// Trigger change event on page load to set default options
document.getElementById('department').dispatchEvent(new Event('change'));
    </script>
</div>
@endsection
</html>