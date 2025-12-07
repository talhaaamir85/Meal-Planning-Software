@extends('layouts.app')

@section('content')
<h1>My Meals</h1>
<a href="{{ route('user_meals.create') }}">Add New Meal</a>

<table border="1" cellpadding="5">
    <tr>
        <th>Recipe</th>
        <th>Servings</th>
        <th>Meal Date</th>
    </tr>
   @foreach($meals as $meal)
<tr>
    <td>{{ $meal->recipe->title }}</td>
    <td>{{ $meal->servings }}</td>
    <td>{{ $meal->meal_date }}</td>
</tr>
@endforeach

</table>
@endsection
