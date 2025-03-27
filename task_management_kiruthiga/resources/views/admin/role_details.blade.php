<div class="p-6 bg-gray-800 shadow-md rounded-lg w-full max-w-4xl text-white">
    <h2 class="text-2xl font-bold mb-4">Role Details</h2>

    <!-- Add Role Form -->
    <form id="roleForm" class="mb-6 flex flex-col gap-3">
        @csrf
        <input type="text" name="role" id="role" placeholder="Enter Role" class="p-2 rounded bg-gray-700 text-white">
        <input type="text" name="department" id="department" placeholder="Enter Department" class="p-2 rounded bg-gray-700 text-white">
        <button type="submit" class="bg-blue-500 px-4 py-2 text-white rounded hover:bg-blue-600 transition">
            Add Role
        </button>
    </form>

    <!-- Role Table -->
    <table class="w-full border border-gray-500 text-white">
        <thead>
            <tr class="bg-gray-700 text-white">
                <th class="p-2 text-left">Role</th>
                <th class="p-2 text-left">Department</th>
                <th class="p-2 text-center">Actions</th>
            </tr>
        </thead>
        <tbody id="roleTableBody">
            @foreach($roles as $role)
            <tr class="border-t border-gray-500">
                <td class="p-2">{{ $role->role }}</td>
                <td class="p-2">{{ $role->department }}</td>
                <td class="p-2 text-center">
                    <button class="bg-red-500 px-3 py-1 rounded text-white hover:bg-red-600 transition"
                        onclick="deleteRole({{ $role->id }})">
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- JavaScript for AJAX Handling -->
<script>
    // Add Role AJAX
    document.getElementById("roleForm").addEventListener("submit", function(event) {
        event.preventDefault();
        let formData = new FormData(this);

        fetch("{{ route('role.store') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            loadRoleDetails(); // Reload Role Details after adding
        })
        .catch(error => console.error("Error adding role:", error));
    });

    // Delete Role AJAX
    function deleteRole(roleId) {
        if (!confirm("Are you sure you want to delete this role?")) return;

        fetch(`/admin/role-details/delete/${roleId}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            loadRoleDetails(); // Reload Role Details after deletion
        })
        .catch(error => console.error("Error deleting role:", error));
    }
</script>
