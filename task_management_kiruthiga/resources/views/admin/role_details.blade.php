@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-semibold mb-4 text-white-800">Role Details</h2>

    <!-- Role Form -->
    <form id="addRoleForm" class="space-y-3 mb-6 bg-gray-100 p-6 rounded-lg shadow">
        @csrf
        <div>
            <label class="block text-gray-700">Role ID (Auto-generated):</label>
            <input type="text" id="role_id" disabled class="w-full p-2 border border-gray-300 rounded bg-gray-200">
        </div>

        <div>
            <label class="block text-gray-700">Role:</label>
            <input type="text" id="role" name="role" placeholder="Enter Role" class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-300">
            <span id="roleError" class="text-red-500 text-sm"></span>
        </div>

        <div>
            <label class="block text-gray-700">Department:</label>
            <input type="text" id="department" name="department" placeholder="Enter Department" class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-300">
            <span id="departmentError" class="text-red-500 text-sm"></span>
        </div>

        <button type="submit" class="bg-blue-400 hover:bg-blue-500 text-white py-2 px-4 rounded transition-all">
            Add Role
        </button>
    </form>

    <!-- Role Details Table -->
  <!-- Role Details Table -->
<div class="overflow-x-auto">
    <table class="w-full border-collapse border border-gray-300 text-sm bg-gray-50 shadow rounded-lg">
        <thead>
            <tr class="bg-gray-700 text-white">
                <th class="border border-gray-300 px-3 py-2">ID</th>
                <th class="border border-gray-300 px-3 py-2">Role</th>
                <th class="border border-gray-300 px-3 py-2">Department</th>
                <th class="border border-gray-300 px-3 py-2">Action</th>
            </tr>
        </thead>
        <tbody id="roleTable">
            @foreach($roles as $role)
            <tr id="roleRow{{ $role->id }}" class="bg-gray-100">
                <td class="border border-gray-300 px-3 py-2 text-gray-900">{{ $role->id }}</td>
                <td class="border border-gray-300 px-3 py-2 text-gray-900">{{ $role->role }}</td>
                <td class="border border-gray-300 px-3 py-2 text-gray-900">{{ $role->department }}</td>
                <td class="border border-gray-300 px-3 py-2">
                    <button onclick="deleteRole({{ $role->id }})" class="bg-red-500 text-white py-1 px-3 rounded">
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

@endsection

@section('scripts')
<script>
 document.querySelector(".add-role-form").addEventListener("submit", function (event) {
    event.preventDefault();
    
    let role = document.querySelector(".role-input").value.trim();
    let department = document.querySelector(".department-input").value.trim();
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    
    // Clear previous error messages
    document.querySelector(".role-error").innerText = "";
    document.querySelector(".department-error").innerText = "";
    
    if (!role || !department) {
        document.querySelector(".role-error").innerText = role ? "" : "Role is required!";
        document.querySelector(".department-error").innerText = department ? "" : "Department is required!";
        return;
    }
    
    fetch("{{ route('role.store') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ role: role, department: department })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Role Added Successfully!");

            // Append new role to the table dynamically
            let newRow = document.createElement("tr");
            newRow.classList.add("role-row");
            newRow.innerHTML = `
                <td class="border border-gray-300 px-3 py-2 text-gray-900">${data.role.id}</td>
                <td class="border border-gray-300 px-3 py-2 text-gray-900">${data.role.role}</td>
                <td class="border border-gray-300 px-3 py-2 text-gray-900">${data.role.department}</td>
                <td class="border border-gray-300 px-3 py-2">
                    <button class="delete-role bg-red-500 text-white py-1 px-3 rounded" data-id="${data.role.id}">
                        Delete
                    </button>
                </td>
            `;
            
            document.querySelector(".role-table").appendChild(newRow);
            
            // Reset form fields without refreshing
            document.querySelector(".add-role-form").reset();
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => console.error("Error:", error));
});

// Event delegation for delete buttons
document.querySelector(".role-table").addEventListener("click", function (event) {
    if (event.target.classList.contains("delete-role")) {
        let roleId = event.target.getAttribute("data-id");
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        fetch(`{{ route('role.destroy', '') }}/${roleId}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "Content-Type": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Role Deleted Successfully!");
                event.target.closest(".role-row").remove();
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => console.error("Error:", error));
    }
});
document.querySelector(".add-role-form").addEventListener("submit", function (event) {
    event.preventDefault();
    
    let role = document.querySelector(".role-input").value.trim();
    let department = document.querySelector(".department-input").value.trim();
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    
    // Clear previous error messages
    document.querySelector(".role-error").innerText = "";
    document.querySelector(".department-error").innerText = "";
    
    if (!role || !department) {
        document.querySelector(".role-error").innerText = role ? "" : "Role is required!";
        document.querySelector(".department-error").innerText = department ? "" : "Department is required!";
        return;
    }
    
    fetch("{{ route('role.store') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ role: role, department: department })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Role Added Successfully!");

            // Append new role to the table dynamically
            let newRow = document.createElement("tr");
            newRow.classList.add("role-row");
            newRow.innerHTML = `
                <td class="border border-gray-300 px-3 py-2 text-gray-900">${data.role.id}</td>
                <td class="border border-gray-300 px-3 py-2 text-gray-900">${data.role.role}</td>
                <td class="border border-gray-300 px-3 py-2 text-gray-900">${data.role.department}</td>
                <td class="border border-gray-300 px-3 py-2">
                    <button class="delete-role bg-red-500 text-white py-1 px-3 rounded" data-id="${data.role.id}">
                        Delete
                    </button>
                </td>
            `;
            
            document.querySelector(".role-table").appendChild(newRow);
            
            // Reset form fields without refreshing
            document.querySelector(".add-role-form").reset();
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => console.error("Error:", error));
});

// Event delegation for delete buttons
document.querySelector(".role-table").addEventListener("click", function (event) {
    if (event.target.classList.contains("delete-role")) {
        let roleId = event.target.getAttribute("data-id");
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        fetch(`{{ route('role.destroy', '') }}/${roleId}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "Content-Type": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Role Deleted Successfully!");
                event.target.closest(".role-row").remove();
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => console.error("Error:", error));
    }
});


</script>

@endsection
