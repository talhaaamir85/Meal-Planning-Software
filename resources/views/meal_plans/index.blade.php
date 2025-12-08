@extends('layouts.app')

@section('content')

<h1>My Meal Calendar</h1>

<a href="{{ route('meal_plans.create') }}">Add New Meal</a>

<ul>
@foreach($mealPlans as $meal)
    <li>{{ $meal->date }} - {{ $meal->recipe->title }} ({{ $meal->servings }} servings)
        <form method="POST" action="{{ route('meal_plans.destroy', $meal) }}">
            @csrf
            @method('DELETE')
            <button type="submit">Remove</button>
        </form>
    </li>
@endforeach
</ul>
@endsection
