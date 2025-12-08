@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Edit My Goals</h1>

    <form action="{{ route('user_goals.update_goals') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        @foreach($goals as $goal)
        <div class="border p-4 rounded">
            <h2 class="font-semibold mb-2">{{ ucfirst($goal->nutrient) }}</h2>

            <div class="mb-2">
                <label class="block mb-1">Target Value:</label>
                <input type="number" name="goals[{{ $goal->id }}][target_value]" value="{{ $goal->target_value }}" step="any" class="border px-2 py-1 rounded w-full">
            </div>

            <div class="mb-2">
                <label class="block mb-1">Unit:</label>
                <input type="text" name="goals[{{ $goal->id }}][unit]" value="{{ $goal->unit }}" class="border px-2 py-1 rounded w-full">
            </div>

            <div class="mb-2">
                <label class="block mb-1">Direction:</label>
                <select name="goals[{{ $goal->id }}][direction]">
    <option value="max" {{ $goal->direction == 'max' ? 'selected' : '' }}>Decrease</option>
    <option value="min" {{ $goal->direction == 'min' ? 'selected' : '' }}>Increase</option>
</select>

            </div>

            <div class="mb-2">
                <label class="block mb-1">Period:</label>
                <select name="goals[{{ $goal->id }}][period]" class="border px-2 py-1 rounded w-full">
                    <option value="day" {{ $goal->period == 'day' ? 'selected' : '' }}>Day</option>
                    <option value="week" {{ $goal->period == 'week' ? 'selected' : '' }}>Week</option>
                </select>
            </div>

            <div class="mb-2">
                <label class="block mb-1">Weight:</label>
                <input type="number" name="goals[{{ $goal->id }}][weight]" value="{{ $goal->weight }}" step="any" class="border px-2 py-1 rounded w-full">
            </div>

            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="goals[{{ $goal->id }}][active]" value="1" {{ $goal->active ? 'checked' : '' }} class="mr-2">
                    Active
                </label>
            </div>
        </div>
        @endforeach

        <button type="submit" class="px-4 py-2 bg-blue-600 text-black rounded hover:bg-blue-700">Save Goals</button>
    </form>
</div>
@endsection
