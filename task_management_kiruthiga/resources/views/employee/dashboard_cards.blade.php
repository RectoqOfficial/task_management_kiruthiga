<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Total Tasks -->
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg text-center">
        <h3 class="text-lg font-semibold text-white">Total Tasks</h3>
        <p class="text-3xl font-bold text-blue-400">{{ $totalTasks }}</p>
    </div>

    <!-- Pending Tasks -->
    <div class="bg-yellow-600 p-6 rounded-lg shadow-lg text-center">
        <h3 class="text-lg font-semibold text-white">Pending Tasks</h3>
        <p class="text-3xl font-bold">{{ $pendingTasks }}</p>
    </div>

    <!-- Started Tasks -->
    <div class="bg-blue-600 p-6 rounded-lg shadow-lg text-center">
        <h3 class="text-lg font-semibold text-white">Started Tasks</h3>
        <p class="text-3xl font-bold">{{ $startedTasks }}</p>
    </div>

    <!-- Completed Tasks -->
    <div class="bg-green-600 p-6 rounded-lg shadow-lg text-center">
        <h3 class="text-lg font-semibold text-white">Completed Tasks</h3>
        <p class="text-3xl font-bold">{{ $completedTasks }}</p>
    </div>

    <!-- Review Tasks -->
    <div class="bg-purple-600 p-6 rounded-lg shadow-lg text-center">
        <h3 class="text-lg font-semibold text-white">Tasks in Review</h3>
        <p class="text-3xl font-bold">{{ $reviewTasks }}</p>
    </div>
</div>
