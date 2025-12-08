@extends('layouts.app')

@section('content')
<h1>Recipes</h1>
<a href="{{ route('recipes.create') }}">Add New Recipe</a>
<a href="{{ route('recipes.suggestions') }}" class="px-4 py-2 bg-green-600 text-black rounded mb-4 inline-block">
    Suggested Recipes
</a>

<table border="1" cellpadding="5">
    <tr>
        <th>Title</th>
        <th>Servings</th>
        <th>Calories</th>
        <th>Protein</th>
        <th>Carbs</th>
        <th>Fat</th>
        <th>Fiber</th>
        <th>CO₂e</th>
    </tr>
    @foreach($recipes as $recipe)
    <tr>
        <td><a href="{{ route('recipes.show', $recipe) }}">{{ $recipe->title }}</a></td>
        <td>{{ $recipe->servings }}</td>
        <td>{{ $recipe->totals->calories ?? 0 }}</td>
        <td>{{ $recipe->totals->protein ?? 0 }}</td>
        <td>{{ $recipe->totals->carbs ?? 0 }}</td>
        <td>{{ $recipe->totals->fat ?? 0 }}</td>
        <td>{{ $recipe->totals->fiber ?? 0 }}</td>
        <td>{{ $recipe->totals->co2e_kg ?? 0 }}</td>
    </tr>
    @endforeach
</table>
@endsection
