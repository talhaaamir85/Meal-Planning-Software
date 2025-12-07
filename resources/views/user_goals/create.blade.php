@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Goal</h1>

    <form action="{{ route('user_goals.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nutrient" class="form-label">Nutrient</label>
            <select name="nutrient" id="nutrient" class="form-select" required>
                @foreach($nutrients as $nutrient)
                    <option value="{{ $nutrient }}">{{ ucfirst($nutrient) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="target_value" class="form-label">Target Value</label>
            <input type="number" step="0.01" name="target_value" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="unit" class="form-label">Unit</label>
            <input type="text" name="unit" class="form-control" placeholder="e.g., g, kcal">
        </div>

        <div class="mb-3">
            <label for="direction" class="form-label">Direction</label>
            <select name="direction" id="direction" class="form-select" required>
                <option value="min">Minimize</option>
                <option value="max">Maximize</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="period" class="form-label">Period</label>
            <select name="period" id="period" class="form-select" required>
                <option value="day">Day</option>
                <option value="week">Week</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="weight" class="form-label">Weight (Optional)</label>
            <input type="number" step="0.01" name="weight" class="form-control" placeholder="Importance weight">
        </div>

        <button type="submit" class="btn btn-success">Save Goal</button>
        <a href="{{ route('user_goals.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
