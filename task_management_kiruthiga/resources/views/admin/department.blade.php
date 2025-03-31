<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departments & Roles</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-black text-white p-6">

    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-center">Manage Departments & Roles</h1>

        <!-- Department Form -->
        <form action="{{ route('departments.store') }}" method="POST" class="mb-6 bg-gray-800 p-4 rounded-lg w-full sm:w-3/4 lg:w-1/2 mx-auto">
            @csrf
            <input type="text" name="name" placeholder="Enter Department Name" required class="w-full p-2 rounded text-black">
            <button type="submit" class="mt-2 w-full px-4 py-2 bg-red-600 hover:bg-red-700 rounded">Add Department</button>
        </form>

        <!-- Display Departments -->
        <div class="space-y-4">
            @foreach ($departments as $department)
                <div class="bg-gray-800 p-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold">{{ $department->name }}</h2>
                        <div class="space-x-2">
                            <button onclick="toggleEditForm('dept-{{ $department->id }}')" class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded">Edit</button>
                            <button onclick="deleteDepartment({{ $department->id }})" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded">Delete</button>
                        </div>
                    </div>

                    <!-- Edit Department Form (Hidden by Default) -->
                    <form id="dept-{{ $department->id }}" action="{{ route('departments.update', $department->id) }}" method="POST" class="mt-2 hidden">
                        @csrf
                        @method('PUT')
                        <input type="text" name="name" value="{{ $department->name }}" required class="w-full p-2 rounded text-black">
                        <button type="submit" class="mt-2 w-full px-4 py-2 bg-green-600 hover:bg-green-700 rounded">Update</button>
                    </form>

                    <!-- Role Form -->
                    <form action="{{ route('roles.store') }}" method="POST" class="mt-2 w-full">
                        @csrf
                        <input type="hidden" name="department_id" value="{{ $department->id }}">
                        <input type="text" name="name" placeholder="Enter Role Name" required class="w-full p-2 rounded text-black">
                        <button type="submit" class="mt-2 w-full px-4 py-2 bg-red-600 hover:bg-red-700 rounded">Add Role</button>
                    </form>

                    <!-- Display Roles -->
                    @if ($department->roles->count())
                        <ul class="mt-2 space-y-1">
                            @foreach ($department->roles as $role)
                                <li class="text-gray-300 flex justify-between items-center">
                                    {{ $role->name }}
                                    <div class="space-x-2">
                                        <button onclick="toggleEditForm('role-{{ $role->id }}')" class="bg-blue-600 hover:bg-blue-700 px-2 py-1 rounded text-sm">Edit</button>
                                        <button onclick="deleteRole({{ $role->id }})" class="bg-red-600 hover:bg-red-700 px-2 py-1 rounded text-sm">Delete</button>
                                    </div>
                                </li>

                                <!-- Edit Role Form (Hidden by Default) -->
                                <form id="role-{{ $role->id }}" action="{{ route('roles.update', $role->id) }}" method="POST" class="mt-2 hidden">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="name" value="{{ $role->name }}" required class="w-full p-2 rounded text-black">
                                    <button type="submit" class="mt-2 w-full px-4 py-2 bg-green-600 hover:bg-green-700 rounded">Update</button>
                                </form>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <script>
        // Toggle Edit Form Visibility
        function toggleEditForm(id) {
            $('#' + id).toggle();
        }

        // Delete Department (AJAX)
        function deleteDepartment(id) {
            if (confirm('Are you sure you want to delete this department?')) {
                $.ajax({
                    url: '/departments/' + id,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert('Department deleted successfully!');
                        location.reload();
                    },
                    error: function() {
                        alert('Failed to delete department.');
                    }
                });
            }
        }

        // Delete Role (AJAX)
        function deleteRole(id) {
            if (confirm('Are you sure you want to delete this role?')) {
                $.ajax({
                    url: '/roles/' + id,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert('Role deleted successfully!');
                        location.reload();
                    },
                    error: function() {
                        alert('Failed to delete role.');
                    }
                });
            }
        }
    </script>

</body>
</html>
