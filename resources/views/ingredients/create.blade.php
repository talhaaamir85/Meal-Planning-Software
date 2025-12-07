@extends('layouts.app')

@section('content')
<h1>Add Ingredient</h1>

<form method="POST" action="{{ route('ingredients.store') }}">
    @csrf
    <label>Name: </label>
    <input type="text" name="name" required><br><br>

    <label>Unit: </label>
    <input type="text" name="unit"><br><br>

    <h3>Nutrition per 100 unit</h3>
    <label>Calories: </label><input type="number" step="0.1" name="nutrition[calories_kcal]"><br>
    <label>Protein: </label><input type="number" step="0.1" name="nutrition[protein_g]"><br>
    <label>Carbs: </label><input type="number" step="0.1" name="nutrition[carbs_g]"><br>
    <label>Fat: </label><input type="number" step="0.1" name="nutrition[fat_g]"><br>
    <label>Fiber: </label><input type="number" step="0.1" name="nutrition[fiber_g]"><br>

    <h3>Carbon per 100 unit</h3>
    <label>CO₂e (kg): </label><input type="number" step="0.01" name="carbon[co2e_kg]"><br><br>

    <button type="submit">Save Ingredient</button>
</form>
@endsection
