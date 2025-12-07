@extends('layouts.app')

@section('content')
<h1>Your Meals</h1>
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Recipe</th>
            <th>Calories</th>
        </tr>
    </thead>
    <tbody>
        @foreach($meals as $meal)
        <tr>
            <td>{{ $meal->meal_date }}</td>
            <td>{{ $meal->recipe->name }}</td>
            <td>{{ $meal->recipe->total_calories }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

@section('content')
<h1>Add Meal</h1>
<form action="{{ route('user_meals.store') }}" method="POST">
    @csrf
    <label for="recipe_id">Recipe</label>
    <select name="recipe_id" id="recipe_id">
        @foreach($recipes as $recipe)
            <option value="{{ $recipe->id }}">{{ $recipe->name }}</option>
        @endforeach
    </select>
    <label for="meal_date">Date</label>
    <input type="date" name="meal_date" id="meal_date">
    <button type="submit">Add Meal</button>
</form>
@endsection
