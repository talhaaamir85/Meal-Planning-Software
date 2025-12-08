<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MealPlan;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;

class MealPlanController extends Controller
{
    public function index()
    {
        $mealPlans = Auth::user()->mealPlans()->with('recipe')->orderBy('date')->get();
        return view('meal_plans.index', compact('mealPlans'));
    }

    public function create()
    {
        $recipes = Recipe::all();
        return view('meal_plans.create', compact('recipes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required|exists:recipes,id',
            'date' => 'required|date',
            'servings' => 'nullable|integer|min:1',
        ]);

        MealPlan::create([
            'user_id' => Auth::id(),
            'recipe_id' => $request->recipe_id,
            'date' => $request->date,
            'servings' => $request->servings ?? 1,
        ]);

        return redirect()->route('meal_plans.index')->with('success', 'Recipe added to your calendar!');
    }

 public function destroy(MealPlan $mealPlan)
{
    if ($mealPlan->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    $mealPlan->delete();
    return back()->with('success', 'Recipe removed from calendar.');
}

   

}
