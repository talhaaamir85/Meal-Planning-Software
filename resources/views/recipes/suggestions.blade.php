@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Suggested Recipes</h1>

@if($recipes->count() > 0)
    <ul>
        @foreach($recipes as $recipe)
            <li>
                {{ $recipe->title }} - 
                Calories: {{ $recipe->totals->calories ?? 0 }}, 
                Protein: {{ $recipe->totals->protein ?? 0 }}, 
                Carbs: {{ $recipe->totals->carbs ?? 0 }}
            </li>
        @endforeach
    </ul>
@else
    <p>No suggestions available right now.</p>
@endif
@endsection
