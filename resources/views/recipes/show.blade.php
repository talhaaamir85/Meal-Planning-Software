@extends('layouts.app')

@section('content')
<h1>{{ $recipe->title }}</h1>
<p>Servings: {{ $recipe->servings }}</p>
<p>Instructions: {{ $recipe->instructions }}</p>

<h3>Ingredients</h3>
<ul>
    @foreach($recipe->ingredients as $ingredient)
        <li>{{ $ingredient->name }}: {{ $ingredient->pivot->quantity }} {{ $ingredient->pivot->unit ?? $ingredient->unit }}</li>
    @endforeach
</ul>

<h3>Nutrition Totals</h3>
<ul>
    <li>Calories: {{ $recipe->totals->calories ?? 0 }}</li>
    <li>Protein: {{ $recipe->totals->protein ?? 0 }}</li>
    <li>Carbs: {{ $recipe->totals->carbs ?? 0 }}</li>
    <li>Fat: {{ $recipe->totals->fat ?? 0 }}</li>
    <li>Fiber: {{ $recipe->totals->fiber ?? 0 }}</li>
    <li>CO₂e: {{ $recipe->totals->co2e_kg ?? 0 }}</li>
</ul>
@endsection
