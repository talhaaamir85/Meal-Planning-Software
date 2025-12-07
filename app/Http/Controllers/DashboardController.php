<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserMeal;
use App\Models\UserGoal;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show the dashboard
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $date = $request->date ? Carbon::parse($request->date) : Carbon::today();

        // Get meals for the day
        $meals = $user->meals()->with('recipe.totals')->whereDate('meal_date', $date)->get();

        // Calculate total nutrition
        $totals = [
            'calories' => 0,
            'protein' => 0,
            'carbs' => 0,
            'fat' => 0,
            'fiber' => 0,
            'co2e_kg' => 0,
        ];
foreach ($meals as $meal) {
    $servings = $meal->servings;
    $recipeTotals = $meal->recipe->totals;

    if($recipeTotals) { // <--- add this check
        $totals['calories'] += $recipeTotals->calories * $servings;
        $totals['protein'] += $recipeTotals->protein * $servings;
        $totals['carbs'] += $recipeTotals->carbs * $servings;
        $totals['fat'] += $recipeTotals->fat * $servings;
        $totals['fiber'] += $recipeTotals->fiber * $servings;
        $totals['co2e_kg'] += $recipeTotals->co2e_kg * $servings;
    }
}

        // Get active goals
        $goals = $user->goals()->where('active', true)->get();

        // Calculate progress
        $progress = [];
        foreach ($goals as $goal) {
            $consumed = $totals[$goal->nutrient] ?? 0;

            $progress[$goal->nutrient] = [
                'target' => $goal->target_value,
                'consumed' => $consumed,
                'percent' => min(100, ($consumed / max($goal->target_value, 1)) * 100),
                'direction' => $goal->direction,
            ];
        }

        return view('dashboard.index', compact('date', 'meals', 'totals', 'goals', 'progress'));
    }
}
