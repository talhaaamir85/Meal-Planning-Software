@extends('layouts.app')

@section('content')
<h1>Add Meal</h1>

<form method="POST" action="{{ route('user_meals.store') }}">
    @csrf
    <label>Recipe: </label>
    <select name="recipe_id" required>
        @foreach(App\Models\Recipe::all() as $recipe)
            <option value="{{ $recipe->id }}">{{ $recipe->title }}</option>
        @endforeach
    </select><br><br>

    <label>Servings: </label>
    <input type="number" step="0.1" name="servings" required value="1"><br><br>

    <label>Meal Date: </label>
    <input type="date" name="meal_date" value="{{ date('Y-m-d') }}" required><br><br>

    <button type="submit">Add Meal</button>
</form>
@endsection
