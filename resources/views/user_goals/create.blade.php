@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-4">Add New Goal</h1>

    <form action="{{ route('user_goals.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium">Nutrient</label>
            <select name="nutrient" required class="w-full border px-2 py-1">
                @foreach($nutrients as $nutrient)
                    <option value="{{ $nutrient }}">{{ ucfirst($nutrient) }}</option>
                @endforeach
            </select>
            @error('nutrient') <div class="text-red-600">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="block font-medium">Target Value</label>
            <input type="number" step="0.01" name="target_value" required class="w-full border px-2 py-1">
            @error('target_value') <div class="text-red-600">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="block font-medium">Unit (optional)</label>
            <input type="text" name="unit" class="w-full border px-2 py-1" placeholder="e.g. g, kcal">
        </div>

        <div>
            <label class="block font-medium">Direction</label>
            <select name="direction" required class="w-full border px-2 py-1">
                <option value="min">Minimize</option>
                <option value="max">Maximize</option>
            </select>
            @error('direction') <div class="text-red-600">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="block font-medium">Period</label>
            <select name="period" required class="w-full border px-2 py-1">
                <option value="day">Day</option>
                <option value="week">Week</option>
            </select>
            @error('period') <div class="text-red-600">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="block font-medium">Weight (importance, optional)</label>
            <input type="number" step="0.1" name="weight" class="w-full border px-2 py-1" placeholder="1">
        </div>

        <div class="pt-3">
            <button type="submit" class="px-4 py-2 bg-green-600 text-black rounded">Save Goal</button>
            <a href="{{ route('user_goals.index') }}" class="ml-2 px-4 py-2 bg-gray-300 rounded">Cancel</a>
        </div>
    </form>
</div>
@endsection
