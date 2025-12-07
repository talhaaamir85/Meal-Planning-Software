@extends('layouts.app')

@section('content')
<h1>Add Recipe</h1>

<form method="POST" action="{{ route('recipes.store') }}">
    @csrf
    <label>Title: </label>
    <input type="text" name="title" required><br><br>

    <label>Servings: </label>
    <input type="number" step="0.1" name="servings" required><br><br>

    <label>Instructions: </label><br>
    <textarea name="instructions" rows="4" cols="50"></textarea><br><br>

    <h3>Ingredients</h3>
    @foreach($ingredients as $ingredient)
        <input type="checkbox" name="ingredients[{{ $loop->index }}][id]" value="{{ $ingredient->id }}">
        {{ $ingredient->name }}
        Quantity: <input type="number" step="0.1" name="ingredients[{{ $loop->index }}][quantity]" placeholder="100">
        Unit: <input type="text" name="ingredients[{{ $loop->index }}][unit]" placeholder="{{ $ingredient->unit }}"><br>
    @endforeach

    <br>
    <button type="submit">Save Recipe</button>
</form>
@endsection
