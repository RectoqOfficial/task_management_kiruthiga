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
<form id="departmentForm" method="POST" class="mb-6 bg-gray-800 p-4 rounded-lg w-full sm:w-3/4 lg:w-1/2 mx-auto">
    @csrf
    <div class="mb-6 bg-gray-800 p-4 rounded-lg w-full mx-auto flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4">
        <input type="text" id="departmentName" name="name" placeholder="Enter Department Name" required 
               class="w-full p-4 text-lg rounded text-black">
        <button type="button" onclick="addDepartment()" 
                class="w-full sm:w-auto px-6 py-3 bg-red-600 hover:bg-red-700 rounded">Add Department</button>
    </div>
</form>



        <!-- Display Departments -->
        <div id="department-list" class="space-y-4">
            @foreach ($departments as $department)
                <div class="bg-gray-800 p-4 rounded-lg department-item" id="department-{{ $department->id }}">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold department-name">{{ $department->name }}</h2>
                      <div class="space-x-2 flex items-center">
    <!-- Inline Edit & Delete Images -->
    <img src="https://img.icons8.com/ios-filled/50/000000/edit.png" 
         alt="edit" 
         class="cursor-pointer w-5 h-5 transition duration-200 filter invert 
                hover:invert-0 hover:brightness-0 hover:sepia 
                hover:hue-rotate-[-50deg] hover:saturate-[500%] hover:brightness-[80%]" 
         onclick="toggleEditForm('dept-edit-{{ $department->id }}')">

    <img src="https://img.icons8.com/ios-filled/50/000000/erase.png" 
         alt="delete" 
         class="cursor-pointer w-5 h-5 transition duration-200 filter invert 
                hover:invert-0 hover:brightness-0 hover:sepia 
                hover:hue-rotate-[-50deg] hover:saturate-[500%] hover:brightness-[80%]" 
         onclick="deleteDepartment({{ $department->id }})">
</div>

                    </div>

                    <!-- Hidden Edit Form for Department -->
                   <div id="dept-edit-{{ $department->id }}" class="hidden mt-2">
    <form onsubmit="event.preventDefault(); updateDepartment({{ $department->id }});" class="w-full flex items-center space-x-4">
        <input type="text" id="dept-name-{{ $department->id }}" name="name" value="{{ $department->name }}" 
               class="w-full p-2 rounded text-black border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">

        <button type="submit" 
                class="px-3 py-2 bg-green-600 hover:bg-green-700 rounded text-white flex items-center justify-center">
            ✔
        </button>

        <img src="https://img.icons8.com/ios-filled/50/000000/close-window.png" 
             alt="cancel" 
             class="cursor-pointer w-5 h-5 transition duration-200 filter invert hover:invert-0 hover:brightness-0 hover:sepia hover:hue-rotate-[-50deg] hover:saturate-[500%] hover:brightness-[80%]" 
             onclick="toggleEditForm('dept-edit-{{ $department->id }}')">
    </form>
</div>


                    <!-- Role Form (Inline) -->
                    <form class="role-form mt-2 w-full flex items-center space-x-4" data-department-id="{{ $department->id }}">
                        @csrf
                        <input type="hidden" name="department_id" value="{{ $department->id }}">
                        <input type="text" name="name" placeholder="Enter Role Name" required class="w-2/3 p-2 rounded text-black">
                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded">Add Role</button>
                    </form>

                    <!-- Display Roles -->
                    <ul class="mt-2 space-y-1 role-list" id="roles-{{ $department->id }}">
                        @foreach ($department->roles as $role)
                            <li id="role-{{ $role->id }}" class="text-gray-300 flex justify-between items-center">
                                <span class="role-name">{{ $role->name }}</span>
  <div class="flex space-x-2 items-center">
    <!-- Inline Edit & Delete Images for Roles -->
    <img src="https://img.icons8.com/ios-filled/50/000000/edit.png" 
         alt="edit" 
         class="cursor-pointer w-5 h-5 transition duration-200 filter invert hover:invert-0 hover:brightness-0 hover:sepia hover:hue-rotate-[-50deg] hover:saturate-[500%] hover:brightness-[80%]" 
         onclick="toggleEditForm('role-edit-{{ $role->id }}')">

    <img src="https://img.icons8.com/ios-filled/50/000000/erase.png" 
         alt="delete" 
         class="cursor-pointer w-5 h-5 transition duration-200 filter invert hover:invert-0 hover:brightness-0 hover:sepia hover:hue-rotate-[-50deg] hover:saturate-[500%] hover:brightness-[80%]" 
         onclick="deleteRole({{ $role->id }})">
</div>



                            </li>

                            <!-- Hidden Edit Form for Role -->
                            <div id="role-edit-{{ $role->id }}" class="hidden mt-2">
    <form onsubmit="event.preventDefault(); updateRole({{ $role->id }});" class="w-full flex items-center space-x-4">
        <input type="text" id="role-name-{{ $role->id }}" name="name" value="{{ $role->name }}" 
               class="w-full p-2 rounded text-black border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">

        <button type="submit" 
                class="px-3 py-2 bg-green-600 hover:bg-green-700 rounded text-white flex items-center justify-center">
            ✔
        </button>

        <img src="https://img.icons8.com/ios-filled/50/000000/close-window.png" 
             alt="cancel" 
             class="cursor-pointer w-5 h-5 transition duration-200 filter invert hover:invert-0 hover:brightness-0 hover:sepia hover:hue-rotate-[-50deg] hover:saturate-[500%] hover:brightness-[80%]" 
             onclick="toggleEditForm('role-edit-{{ $role->id }}')">
    </form>
</div>

                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>

<script>

// Toggle Edit Form Visibility
function toggleEditForm(id) {
    var form = document.getElementById(id);
    if (form) {
        form.classList.toggle('hidden'); // Toggle visibility
    } else {
        console.error("Edit form not found: " + id);
    }
}

// Add Department
function addDepartment() {
    var name = $("#departmentName").val();

    $.ajax({
        url: '{{ route("departments.store") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            name: name
        }
    }).done(response => {
        alert(response.message);

        // Add the new department to the department list dynamically
        $("#department-list").append(`
            <div class="bg-gray-800 p-4 rounded-lg department-item" id="department-${response.department.id}">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold department-name">${response.department.name}</h2>
                    <div class="space-x-2">
                        <button onclick="toggleEditForm('dept-edit-${response.department.id}')" class="text-green-400 text-xl">✔</button>
                        <button onclick="deleteDepartment(${response.department.id})" class="text-red-400 text-xl">✖</button>
                    </div>
                </div>

                <!-- Hidden Edit Form for Department -->
                <div id="dept-edit-${response.department.id}" class="hidden mt-2">
                    <form onsubmit="event.preventDefault(); updateDepartment(${response.department.id});" class="w-full">
                        @csrf
                        <input type="text" id="dept-name-${response.department.id}" name="name" value="${response.department.name}" class="w-full p-2 rounded text-black">
                        <button type="submit" class="mt-2 w-full px-4 py-2 bg-green-600 hover:bg-green-700 rounded">✔</button>
                    </form>
                </div>
            </div>
                <!-- Role Form -->
                <form class="role-form mt-2 w-full" data-department-id="${response.department.id}">
                    @csrf
                    <input type="hidden" name="department_id" value="${response.department.id}">
                    <input type="text" name="name" placeholder="Enter Role Name" required class="w-full p-2 rounded text-black">
                    <button type="submit" class="mt-2 w-full px-4 py-2 bg-red-600 hover:bg-red-700 rounded">Add Role</button>
                </form>

                <!-- Display Roles -->
                <ul class="mt-2 space-y-1 role-list" id="roles-${response.department.id}">
                    <!-- Roles will be appended here dynamically -->
                </ul>
            </div>
        `);

        // Reset the input field for the next department
        $("#departmentName").val('');
    }).fail(xhr => {
        alert(xhr.responseJSON.error || 'Failed to add department.');
    });
}

//  Add Role without Reloading
$(document).on('submit', '.role-form', function(event) {
    event.preventDefault();
    var form = $(this);
    var departmentId = form.data('department-id');

    $.ajax({
        url: '{{ route('roles.store') }}',
        method: 'POST',
        data: form.serialize(),
        success: function(response) {
            alert(response.message);

            // Append the new role to the list dynamically
            $("#roles-" + departmentId).append(`
                <li id="role-${response.role.id}" class="text-gray-300 flex justify-between items-center">
                    <span class="role-name">${response.role.name}</span>
                    <div class="space-x-2">
                        <button onclick="toggleEditForm('role-edit-${response.role.id}')" class="bg-blue-600 hover:bg-blue-700 px-2 py-1 rounded text-sm">✔</button>
                        <button onclick="deleteRole(${response.role.id})" class="bg-red-600 hover:bg-red-700 px-2 py-1 rounded text-sm">✖</button>
                    </div>
                </li>

                <!-- Hidden Edit Form for Role -->
                <div id="role-edit-${response.role.id}" class="hidden mt-2">
                    <form onsubmit="event.preventDefault(); updateRole(${response.role.id});" class="w-full">
                        @csrf
                        <input type="text" id="role-name-${response.role.id}" name="name" value="${response.role.name}" class="w-full p-2 rounded text-black">
                        <button type="submit" class="mt-2 w-full px-4 py-2 bg-green-600 hover:bg-green-700 rounded">Update Role</button>
                    </form>
                </div>
            `);
            form[0].reset(); // Clear the input field
        },
        error: function(xhr) {
            alert(xhr.responseJSON.error || 'Failed to add role.');
        }
    });
});

//  Delete Role without Reloading
function deleteRole(id) {
    if (confirm('Are you sure you want to delete this role?')) {
        $.ajax({
            url: '/roles/' + id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response.message);
                $("#role-" + id).remove(); // Remove the role from UI without reload
            },
            error: function(xhr) {
                alert(xhr.responseJSON.error || 'Failed to delete role.');
            }
        });
    }
}

//  Delete Department without Reloading
function deleteDepartment(id) {
    if (confirm('Are you sure you want to delete this department?')) {
        $.ajax({
            url: '/departments/' + id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response.message);
                $("#department-" + id).remove(); // Remove department div
            },
            error: function(xhr) {
                alert(xhr.responseJSON.error || 'Failed to delete department.');
            }
        });
    }
}

//  Update Department
function updateDepartment(id) {
    var newName = $("#dept-name-" + id).val();
    
    $.ajax({
        url: '{{ url("departments") }}/' + id,
        type: 'POST', // Use POST with _method override
        data: {
            _token: '{{ csrf_token() }}',
            _method: 'PUT',  // Manually override to PUT
            name: newName
        }
    }).done(response => {
        alert(response.message);
        $("#department-" + id + " .department-name").text(newName);
        toggleEditForm("dept-edit-" + id);
    }).fail(xhr => {
        alert(xhr.responseJSON?.error || 'Failed to update department.');
    });
}

//  Update Role
function updateRole(id) {
    var newName = $("#role-name-" + id).val();
    
    $.ajax({
        url: '{{ url("roles") }}/' + id,
        type: 'POST', // Laravel doesn't support PUT directly in forms, so use POST with `_method`
        data: {
            _token: '{{ csrf_token() }}',
            _method: 'PUT',  // Manually override to PUT
            name: newName
        }
    }).done(response => {
        alert(response.message);
        $("#role-" + id + " .role-name").text(newName);
        toggleEditForm("role-edit-" + id);
    }).fail(xhr => {
        alert(xhr.responseJSON?.error || 'Failed to update role.');
    });
}

</script>


</body>
</html>
