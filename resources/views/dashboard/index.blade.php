@extends('layouts.app')
<nav style="margin-bottom:20px;">
    <a href="{{ route('user_meals.index') }}" class="btn btn-secondary" style="margin-right:8px;">All Meals</a>
    <a href="{{ route('recipes.index') }}" class="btn btn-secondary" style="margin-right:8px;">Recipes</a>
   <a href="{{ route('user_goals.index') }}" class="btn btn-secondary" style="margin-right:8px;">My Goals</a>
     <a href="{{ route('biometric_entries.index') }}" class="btn btn-secondary" style="margin-right:8px;">
    My Biometrics
</a>
<a href="{{ route('meal_plans.index') }}" class="nav-link">Meal Plan</a>

    <a href="{{ route('profile.edit') }}" class="btn btn-secondary">Profile</a>
   

    <a href="{{ route('logout') }}" class="btn btn-danger" style="margin-right:8px;"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
       Logout
    </a>
</nav>


<form id="logout-form" action="{{ route('logout') }}" method="POST">
    @csrf
</form>

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    
    <h1 class="text-2xl font-bold mb-4">Dashboard for {{ $date->format('d M Y') }}</h1>

    {{-- Meals --}}
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Meals</h2>
        @if($meals->isEmpty())
            <p>No meals logged for this day.</p>
        @else
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 p-2 text-left">Recipe</th>
                        <th class="border border-gray-300 p-2 text-left">Servings</th>
                        <th class="border border-gray-300 p-2 text-left">Calories</th>
                        <th class="border border-gray-300 p-2 text-left">Protein</th>
                        <th class="border border-gray-300 p-2 text-left">Carbs</th>
                        <th class="border border-gray-300 p-2 text-left">Fat</th>
                        <th class="border border-gray-300 p-2 text-left">Fiber</th>
                        <th class="border border-gray-300 p-2 text-left">CO₂e (kg)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($meals as $meal)
                        @if($meal->recipe && $meal->recipe->totals)
                        <tr>
                            <td class="border border-gray-300 p-2">{{ $meal->recipe->title }}</td>
                            <td class="border border-gray-300 p-2">{{ $meal->servings }}</td>
                            <td class="border border-gray-300 p-2">{{ $meal->recipe->totals->calories * $meal->servings }}</td>
                            <td class="border border-gray-300 p-2">{{ $meal->recipe->totals->protein * $meal->servings }}</td>
                            <td class="border border-gray-300 p-2">{{ $meal->recipe->totals->carbs * $meal->servings }}</td>
                            <td class="border border-gray-300 p-2">{{ $meal->recipe->totals->fat * $meal->servings }}</td>
                            <td class="border border-gray-300 p-2">{{ $meal->recipe->totals->fiber * $meal->servings }}</td>
                            <td class="border border-gray-300 p-2">{{ $meal->recipe->totals->co2e_kg * $meal->servings }}</td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Totals --}}
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Nutrition Totals</h2>
        <ul>
            <li>Calories: {{ $totals['calories'] }}</li>
            <li>Protein: {{ $totals['protein'] }} g</li>
            <li>Carbs: {{ $totals['carbs'] }} g</li>
            <li>Fat: {{ $totals['fat'] }} g</li>
            <li>Fiber: {{ $totals['fiber'] }} g</li>
            <li>CO₂e: {{ $totals['co2e_kg'] }} kg</li>
        </ul>
    </div>

    {{-- Goals --}}
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Goals Progress</h2>
        @if($goals->isEmpty())
            <p>No goals set yet.</p>
        @else
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 p-2 text-left">Nutrient</th>
                        <th class="border border-gray-300 p-2 text-left">Target</th>
                        <th class="border border-gray-300 p-2 text-left">Consumed</th>
                        <th class="border border-gray-300 p-2 text-left">Progress</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($goals as $goal)
                        <tr>
                            <td class="border border-gray-300 p-2">{{ ucfirst($goal->nutrient) }}</td>
                            <td class="border border-gray-300 p-2">{{ $goal->target_value }} {{ $goal->unit ?? '' }}</td>
                            <td class="border border-gray-300 p-2">{{ $totals[$goal->nutrient] ?? 0 }} {{ $goal->unit ?? '' }}</td>
                            <td class="border border-gray-300 p-2">
                                <div class="w-full bg-gray-200 h-4 rounded">
                                    <div class="bg-green-500 h-4 rounded" style="width: {{ $progress[$goal->nutrient]['percent'] }}%"></div>
                                </div>
                                {{ round($progress[$goal->nutrient]['percent'], 2) }}%
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>
@endsection
