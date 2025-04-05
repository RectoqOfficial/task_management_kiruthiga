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
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-4 text-center">Manage Departments & Roles</h1>

        <!-- Department Form -->
        <form id="departmentForm" method="POST" class="mb-4 bg-gray-800 p-4 rounded-md w-full flex items-center space-x-2 hover:shadow-lg transition-shadow duration-300">
            @csrf
            <input type="text" id="departmentName" name="name" placeholder="Enter Department Name" required class="flex-1 p-2 rounded text-black w-3/4 hover:outline hover:outline-2 hover:outline-[#ff0003] transition-colors duration-300">
            <button type="button" onclick="addDepartment()" class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded text-sm">
            <span>Add</span>
            </button>
        </form>

        <!-- Display Departments -->
        <div id="department-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($departments as $department)
            <div class="bg-gray-800 p-4 rounded-md department-item hover:bg-gray-700 hover:shadow-lg transition duration-300 flex flex-col items-center text-center w-full" id="department-{{ $department->id }}">
                
                <div class="flex justify-between items-center w-full mb-2">
                <h2 class="text-lg font-semibold department-name">{{ $department->name }}</h2>
                <div class="space-x-2 flex">
                    <img src="/build/assets/img/update.png" 
                     onclick="toggleEditForm('dept-edit-{{ $department->id }}')" 
                     class="w-5 h-5 cursor-pointer"
                     style="filter: invert(48%) sepia(94%) saturate(2977%) hue-rotate(102deg) brightness(93%) contrast(89%);">

                    <img src="/build/assets/img/delete.png" 
                     onclick="deleteDepartment({{ $department->id }})" 
                     class="w-5 h-5 cursor-pointer" 
                     style="filter: invert(19%) sepia(88%) saturate(7482%) hue-rotate(358deg) brightness(102%) contrast(119%);">
                </div>
                </div>

                <!-- Role Form -->
                <form class="role-form mb-2 w-full flex flex-col items-center space-y-2 hover:shadow-lg transition-shadow duration-300" data-department-id="{{ $department->id }}">
                @csrf
                <input type="hidden" name="department_id" value="{{ $department->id }}">
                <input type="text" name="name" placeholder="Enter Role Name" required class="w-full p-2 rounded text-black hover:outline hover:outline-2 hover:outline-[#ff0003] transition-colors duration-300">
                <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 rounded text-sm w-full">
                    <span>Add</span>
                </button>
                </form>

                <!-- Display Roles -->
                <ul class="space-y-2 w-full text-center" id="roles-{{ $department->id }}">
                @foreach ($department->roles as $role)
                    <li id="role-{{ $role->id }}" class="text-gray-300 flex justify-between items-center bg-gray-900 p-2 rounded-md hover:bg-gray-800 hover:shadow-lg transition duration-300">
                    <span class="role-name flex-1 text-center">{{ $role->name }}</span>
                    <div class="space-x-2 flex">
                        <img src="/build/assets/img/update.png" 
                         onclick="toggleEditForm('role-edit-{{ $role->id }}')" 
                         class="w-5 h-5 cursor-pointer"
                         style="filter: invert(48%) sepia(94%) saturate(2977%) hue-rotate(102deg) brightness(93%) contrast(89%);">

                        <img src="/build/assets/img/delete.png" 
                         onclick="deleteRole({{ $role->id }})" 
                         class="w-5 h-5 cursor-pointer" 
                         style="filter: invert(18%) sepia(86%) saturate(7482%) hue-rotate(358deg) brightness(102%) contrast(119%);">
                    </div>
                    </li>

                    <!-- Hidden Edit Form for Role -->
                    <div id="role-edit-{{ $role->id }}" class="hidden mt-2 w-full">
                    <form onsubmit="event.preventDefault(); updateRole({{ $role->id }});" class="w-full">
                        @csrf
                        <input type="text" id="role-name-{{ $role->id }}" name="name" value="{{ $role->name }}" class="w-full p-2 rounded text-black hover:outline hover:outline-2 hover:outline-[#ff0003] transition-colors duration-300">
                                    <button type="submit" class="mt-2 w-full px-3 py-1 bg-green-600 hover:bg-green-700 rounded text-sm">
                                        <img src="/build/assets/img/save.png" alt="Save" class="inline w-4 h-4 mr-1">
                                        <span>Save</span>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </ul>

                </div>
            @endforeach
        </div>
    </div>




<script>
    // ✅ Toggle Edit Form Visibility
  // Toggle Edit Form Visibility
function toggleEditForm(id) {
    var form = document.getElementById(id);
    if (form) {
        form.classList.toggle('hidden'); // Toggle visibility
    } else {
        console.error("Edit form not found: " + id);
    }
}

// ✅ Add Department
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

        $("#department-list").append(`
            <div class="bg-gray-800 p-4 rounded-md department-item hover:bg-gray-700 transition duration-200" id="department-${response.department.id}">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-semibold department-name">${response.department.name}</h2>
                    <div class="space-x-2 flex">
                        <img src="/build/assets/img/update.png" onclick="toggleEditForm('dept-edit-${response.department.id}')" 
                             class="w-5 h-5 cursor-pointer"
                             style="filter: invert(48%) sepia(94%) saturate(2977%) hue-rotate(102deg) brightness(93%) contrast(89%);">
                             
                        <img src="/build/assets/img/delete.png" onclick="deleteDepartment(${response.department.id})" 
                             class="w-5 h-5 cursor-pointer" 
                             style="filter: invert(19%) sepia(88%) saturate(7482%) hue-rotate(358deg) brightness(102%) contrast(119%);">
                    </div>
                </div>
                <div id="dept-edit-${response.department.id}" class="hidden mb-2">
                    <form onsubmit="event.preventDefault(); updateDepartment(${response.department.id});">
                        @csrf
                        <input type="text" id="dept-name-${response.department.id}" name="name" value="${response.department.name}" class="w-full p-2 rounded text-black">
                        <button type="submit" class="mt-2 w-full px-3 py-1 bg-green-600 hover:bg-green-700 rounded text-sm">
                            <img src="/build/assets/img/save.png" alt="Save" class="inline w-4 h-4 mr-1"> Save
                        </button>
                    </form>
                </div>
                <form class="role-form mb-2 w-full" data-department-id="${response.department.id}">
                    @csrf
                    <input type="hidden" name="department_id" value="${response.department.id}">
                    <input type="text" name="name" placeholder="Enter Role Name" required class="w-full p-2 rounded text-black">
                    <button type="submit" class="mt-2 w-full px-3 py-1 bg-red-600 hover:bg-red-700 rounded text-sm">Add</button>
                </form>
                <ul class="space-y-1 role-list" id="roles-${response.department.id}"></ul>
            </div>
        `);
        $("#departmentName").val('');
    }).fail(xhr => {
        alert(xhr.responseJSON.error || 'Failed to add department.');
    });
}

// ✅ Add Role without Reloading
$(document).on('submit', ".role-form", function(event) {
    event.preventDefault();
    var form = $(this);
    var departmentId = form.data('department-id');

    $.ajax({
        url: '{{ route("roles.store") }}',
        method: 'POST',
        data: form.serialize(),
        success: function(response) {
            alert(response.message);
            $("#roles-" + departmentId).append(`
                <li id="role-${response.role.id}" class="text-gray-300 flex justify-between items-center bg-gray-900 p-2 rounded-md hover:bg-gray-800 transition duration-200">
                    <span class="role-name flex-1 text-center">${response.role.name}</span>
                    <div class="space-x-2 flex">
                        <img src="/build/assets/img/update.png" onclick="toggleEditForm('role-edit-${response.role.id}')" 
                             class="w-5 h-5 cursor-pointer"
                             style="filter: invert(48%) sepia(94%) saturate(2977%) hue-rotate(102deg) brightness(93%) contrast(89%);">

                        <img src="/build/assets/img/delete.png" onclick="deleteRole(${response.role.id})" 
                             class="w-5 h-5 cursor-pointer" 
                             style="filter: invert(18%) sepia(86%) saturate(7482%) hue-rotate(358deg) brightness(102%) contrast(119%);">
                    </div>
                </li>
                <div id="role-edit-${response.role.id}" class="hidden mt-2">
                    <form onsubmit="event.preventDefault(); updateRole(${response.role.id});">
                        @csrf
                        <input type="text" id="role-name-${response.role.id}" name="name" value="${response.role.name}" class="w-full p-2 rounded text-black">
                        <button type="submit" class="mt-2 w-full px-3 py-1 bg-green-600 hover:bg-green-700 rounded text-sm">
                            <img src="/build/assets/img/save.png" alt="Save" class="inline w-4 h-4 mr-1"> Save
                        </button>
                    </form>
                </div>
            `);
            form[0].reset();
        },
        error: function(xhr) {
            alert(xhr.responseJSON.error || 'Failed to add role.');
        }
    });
});


    // ✅ Delete Role without Reloading
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


    // ✅ Delete Department without Reloading
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

// ✅ Update Department
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


// ✅ Update Role
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
