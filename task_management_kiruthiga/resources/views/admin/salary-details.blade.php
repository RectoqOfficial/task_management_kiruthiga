@extends('layouts.app')

@section('content')
<div class="p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold text-gray-700 mb-4">Employee Task-wise Salary Details</h2>

    <table class="min-w-full table-auto text-sm text-left border">
        <thead class="bg-gray-200">
            <tr>
                 <th class="px-4 py-2">Id</th>
                <th class="px-4 py-2">Employee Name</th>
                <th class="px-4 py-2">Task Title</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Start Date</th>
                <th class="px-4 py-2">Deadline</th>
                <th class="px-4 py-2">Overdue Days</th>
                <th class="px-4 py-2">Salary (Rs.)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($salaryData as $data)
                <tr class="border-t">
                    <td class="px-4 py-2 text-black">{{ $data['task_id'] }}</td>
                    <td class="px-4 py-2 text-black">{{ $data['employee'] }}</td>
                    <td class="px-4 py-2 text-black">{{ $data['task_title'] }}</td>
                    <td class="px-4 py-2 text-black">{{ $data['status'] }}</td>
                    <td class="px-4 py-2 text-black">{{ $data['start_date'] ?  $data['start_date']: 'Task not Started'}}</td>
  
                    <td class="px-4 py-2 text-black">{{ $data['deadline'] }}</td>
                    <td class="px-4 py-2 text-black">{{ $data['overdue_days'] }} day(s)</td>
                    <td class="px-4 py-2 font-bold text-green-700">  ₹{{ $data['salary'] }}</td>
                </tr>
 

            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">No salary records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
