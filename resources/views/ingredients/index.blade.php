@extends('layouts.app')

@section('content')
<h1>Ingredients</h1>
<a href="{{ route('ingredients.create') }}">Add New Ingredient</a>

<table border="1" cellpadding="5">
    <tr>
        <th>Name</th>
        <th>Unit</th>
        <th>Calories / 100{{ $ingredient->unit ?? 'g' }}</th>
        <th>CO₂e / 100{{ $ingredient->unit ?? 'g' }}</th>
    </tr>
    @foreach($ingredients as $ingredient)
    <tr>
        <td><a href="{{ route('ingredients.show', $ingredient) }}">{{ $ingredient->name }}</a></td>
        <td>{{ $ingredient->unit }}</td>
        <td>{{ $ingredient->nutrition->calories_kcal ?? 0 }}</td>
        <td>{{ $ingredient->carbon->co2e_kg ?? 0 }}</td>
    </tr>
    @endforeach
</table>
@endsection
