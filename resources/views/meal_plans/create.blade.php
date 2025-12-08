@extends('layouts.app')

@section('content')
<h1>Add Recipe to Calendar</h1>

<form action="{{ route('meal_plans.store') }}" method="POST">
    @csrf
    <div>
        <label>Select Recipe:</label>
        <select name="recipe_id">
            @foreach($recipes as $recipe)
                <option value="{{ $recipe->id }}">{{ $recipe->title }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Date:</label>
        <input type="date" name="date" required>
    </div>

    <div>
        <label>Servings:</label>
        <input type="number" name="servings" value="1" min="1">
    </div>

    <button type="submit">Add to Calendar</button>
</form>
@endsection
