@extends('layouts.app')

@section('content')
<h1>{{ $ingredient->name }}</h1>
<p>Unit: {{ $ingredient->unit }}</p>

<h3>Nutrition per 100 {{ $ingredient->unit }}</h3>
<ul>
    <li>Calories: {{ $ingredient->nutrition->calories_kcal ?? 0 }}</li>
    <li>Protein: {{ $ingredient->nutrition->protein_g ?? 0 }} g</li>
    <li>Carbs: {{ $ingredient->nutrition->carbs_g ?? 0 }} g</li>
    <li>Fat: {{ $ingredient->nutrition->fat_g ?? 0 }} g</li>
    <li>Fiber: {{ $ingredient->nutrition->fiber_g ?? 0 }} g</li>
</ul>

<h3>Carbon footprint</h3>
<p>{{ $ingredient->carbon->co2e_kg ?? 0 }} kg CO₂e</p>
@endsection
