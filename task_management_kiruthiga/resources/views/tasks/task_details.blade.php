<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Task Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-gray-900 text-white min-h-screen">
    <h2 class="text-2xl font-bold mb-4 text-center">Task Details</h2>

    <!-- Task Form -->
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
        <form id="taskForm" class="space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300">Task Title</label>
                    <input type="text" id="taskTitle" class="w-full px-4 py-2 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 hover:border-blue-300" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300">Description</label>
                    <input type="text" id="description" class="w-full px-4 py-2 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 hover:border-blue-300" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300">Department</label>
                    <input type="text" id="department" class="w-full px-4 py-2 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 hover:border-blue-300" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300">Role</label>
                    <input type="text" id="role" class="w-full px-4 py-2 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 hover:border-blue-300" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300">Assigned To</label>
                    <input type="text" id="assignedTo" class="w-full px-4 py-2 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 hover:border-blue-300" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300">No. of Days</label>
                    <input type="number" id="noOfDays" class="w-full px-4 py-2 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 hover:border-blue-300" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300">Task Create Date</label>
                    <input type="date" id="taskCreateDate" class="w-full px-4 py-2 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 hover:border-blue-300" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300">Task Start Date</label>
                    <input type="date" id="taskStartDate" class="w-full px-4 py-2 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 hover:border-blue-300" required onchange="calculateDeadline()">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300">Deadline</label>
                    <input type="text" id="deadline" class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 cursor-not-allowed" readonly>
                </div>
            </div>

            <button type="button" onclick="addTask()" class="mt-4 px-6 py-2 bg-violet-300 text-white rounded-lg hover:bg-violet-400 transition-colors focus:outline-none focus:ring-2 focus:ring-violet-500">
                Add Task
            </button>
            <p id="error-message" class="text-red-500 mt-2 hidden">Please fill all fields.</p>
        </form>
    </div>

    <!-- Task Table with Horizontal Scroll -->
    <div class="mt-6 bg-gray-800 p-6 rounded-lg shadow-lg overflow-x-auto">
        <h3 class="text-xl font-semibold mb-3">Task List</h3>
        <table class="w-full border-collapse border border-gray-600 table-auto">
            <thead>
                <tr class="bg-gray-700">
                    <th class="border px-4 py-2 text-sm">ID</th>
                    <th class="border px-4 py-2 text-sm">Task Title</th>
                    <th class="border px-4 py-2 text-sm">Assigned To</th>
                    <th class="border px-4 py-2 text-sm">Status</th>
                    <th class="border px-4 py-2 text-sm">Description</th>
                    <th class="border px-4 py-2 text-sm">Task Start Date</th>
                    <th class="border px-4 py-2 text-sm">Task Create Date</th>
                    <th class="border px-4 py-2 text-sm">No. of Days</th>
                    <th class="border px-4 py-2 text-sm">Remarks</th>
                    <th class="border px-4 py-2 text-sm">Actions</th>
                </tr>
            </thead>
            <tbody id="taskTableBody"></tbody>
        </table>
    </div>
</div>

<script>
    let taskId = 1;

    function calculateDeadline() {
        let startDate = document.getElementById("taskStartDate").value;
        let days = document.getElementById("noOfDays").value;

        if (startDate && days) {
            let deadline = new Date(startDate);
            deadline.setDate(deadline.getDate() + parseInt(days));
            document.getElementById("deadline").value = deadline.toISOString().split('T')[0];
        }
    }

    function addTask() {
        let taskTitle = document.getElementById("taskTitle").value;
        let description = document.getElementById("description").value;
        let department = document.getElementById("department").value;
        let role = document.getElementById("role").value;
        let assignedTo = document.getElementById("assignedTo").value;
        let noOfDays = document.getElementById("noOfDays").value;
        let taskCreateDate = document.getElementById("taskCreateDate").value;
        let taskStartDate = document.getElementById("taskStartDate").value;
        let deadline = document.getElementById("deadline").value;

        // Show error message if any field is empty
        if (!taskTitle || !description || !department || !role || !assignedTo || !noOfDays || !taskCreateDate || !taskStartDate) {
            document.getElementById("error-message").classList.remove("hidden");
            return;
        }

        // Hide error message if all fields are filled
        document.getElementById("error-message").classList.add("hidden");

        let tableBody = document.getElementById("taskTableBody");
        let row = document.createElement("tr");

        row.innerHTML = ` 
            <td class="border px-4 py-2">${taskId++}</td>
            <td class="border px-4 py-2">${taskTitle}</td>
            <td class="border px-4 py-2">${assignedTo}</td>
            <td class="border px-4 py-2"><span class="text-yellow-500">Pending</span></td>
            <td class="border px-4 py-2">${description}</td>
            <td class="border px-4 py-2">${taskStartDate}</td>
            <td class="border px-4 py-2">${taskCreateDate}</td>
            <td class="border px-4 py-2">${noOfDays}</td>
            <td class="border px-4 py-2">
                <textarea class="w-full px-2 py-1 border rounded-lg" placeholder="Employee/Admin Message"></textarea>
            </td>
            <td class="border px-4 py-2">
                <button onclick="deleteTask(this)" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors">Delete</button>
            </td>
        `;

        tableBody.appendChild(row);

        document.getElementById("taskForm").reset();
        document.getElementById("deadline").value = "";
    }

    function deleteTask(button) {
        button.parentElement.parentElement.remove();
    }
</script>
@endsection
