<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Role Details</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-4">Role Details</h2>

    <!-- Button to Open Modal -->
    <button onclick="openModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Add Role
    </button>

    <!-- Role Modal -->
    <div id="roleModal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-800 bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h3 class="text-lg font-semibold mb-3">Add Role</h3>
            <form id="addRoleForm">
                @csrf
                <label class="block text-gray-700">Role:</label>
                <input type="text" id="role" name="role" placeholder="Enter Role"
                    class="w-full p-2 border border-gray-300 rounded mb-2">
                <span id="roleError" class="text-red-500 text-sm"></span>

                <label class="block text-gray-700">Department:</label>
                <input type="text" id="department" name="department" placeholder="Enter Department"
                    class="w-full p-2 border border-gray-300 rounded mb-2">
                <span id="departmentError" class="text-red-500 text-sm"></span>

                <div class="flex justify-end">
                    <button type="button" onclick="closeModal()"
                        class="bg-gray-400 hover:bg-gray-500 text-white py-2 px-4 rounded mr-2">
                        Cancel
                    </button>
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">
                        Add Role
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Role Details Table -->
  <!-- Role Details Table -->
<div class="mt-6">
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-blue-500 text-white">
                <th class="border border-gray-300 px-4 py-2">ID</th>
                <th class="border border-gray-300 px-4 py-2">Role</th>
                <th class="border border-gray-300 px-4 py-2">Department</th>
                <th class="border border-gray-300 px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody id="roleTable">
            @foreach($roles as $role)
            <tr id="roleRow{{ $role->id }}" class="hover:bg-blue-100">
                <td class="border border-gray-300 px-4 py-2">{{ $role->id }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $role->role }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $role->department }}</td>
                <td class="border border-gray-300 px-4 py-2">
                    <button onclick="deleteRole({{ $role->id }})"
                        class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded">
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('scripts')
<script>
   document.addEventListener("DOMContentLoaded", function () {
    // Open & Close Modal
    function openModal() {
        document.getElementById("roleModal").classList.remove("hidden");
    }
    function closeModal() {
        document.getElementById("roleModal").classList.add("hidden");
    }

    // ADD ROLE FORM
    document.getElementById("addRoleForm").addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent default form submission

        let role = document.getElementById("role").value.trim();
        let department = document.getElementById("department").value.trim();
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        if (role === "" || department === "") {
            alert("Role and Department fields cannot be empty!");
            return;
        }

        fetch("{{ route('role.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                role: role,
                department: department
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Role Added Successfully!");

                let newRow = document.createElement("tr");
                newRow.setAttribute("id", "roleRow" + data.role.id);
                newRow.innerHTML = `
                    <td class="border border-gray-300 px-4 py-2">${data.role.id}</td>
                    <td class="border border-gray-300 px-4 py-2">${data.role.role}</td>
                    <td class="border border-gray-300 px-4 py-2">${data.role.department}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <button onclick="deleteRole(${data.role.id})"
                            class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded">
                            Delete
                        </button>
                    </td>
                `;
                document.getElementById("roleTable").appendChild(newRow);

                closeModal(); // Close the modal
                document.getElementById("addRoleForm").reset(); // Clear form
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => console.error("Error:", error));
    });

    // DELETE ROLE FUNCTION
    window.deleteRole = function (id) {
        if (confirm("Are you sure you want to delete this role?")) {
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

            fetch(`/roles/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Role Deleted Successfully!");
                    document.getElementById("roleRow" + id).remove();
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(error => console.error("Error:", error));
        }
    };
});


</script>
@endsection
