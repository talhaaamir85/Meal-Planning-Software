@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-4">My Goals</h1>

    <!-- Add New Goal button -->
    <a href="{{ route('user_goals.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-black rounded hover:bg-blue-700">Add New Goal</a>

    <!-- Success message -->
    @if(session('success'))
        <div class="mb-3 text-green-700">{{ session('success') }}</div>
    @endif

    @if($goals->count() > 0)
    <div class="overflow-auto">
        <table class="min-w-full bg-blue border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">Nutrient</th>
                    <th class="px-4 py-2 border">Target</th>
                    <th class="px-4 py-2 border">Unit</th>
                    <th class="px-4 py-2 border">Direction</th>
                    <th class="px-4 py-2 border">Period</th>
                    <th class="px-4 py-2 border">Weight</th>
                    <th class="px-4 py-2 border">Active</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($goals as $goal)
                <tr>
                    <td class="px-4 py-2 border">{{ ucfirst($goal->nutrient) }}</td>
                    <td class="px-4 py-2 border">{{ $goal->target_value }}</td>
                    <td class="px-4 py-2 border">{{ $goal->unit ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $goal->direction }}</td>
                    <td class="px-4 py-2 border">{{ $goal->period }}</td>
                    <td class="px-4 py-2 border">{{ $goal->weight ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $goal->active ? 'Yes' : 'No' }}</td>
                    <td class="px-4 py-2 border flex gap-2">
                        <!-- Edit Button -->
                       <a href="{{ route('user_goals.edit', $goal->id) }}">Edit</a>

                        <!-- Deactivate Button -->
                        @if($goal->active)
                        <form action="{{ route('user_goals.deactivate', $goal->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="px-3 py-1 bg-yellow-500 text-black rounded hover:bg-yellow-600">Deactivate</button>
                        </form>
                        @else
                        <span class="text-sm text-black">Inactive</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p>No goals set yet.</p>
    @endif
</div>
@endsection
