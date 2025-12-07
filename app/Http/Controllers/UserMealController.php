<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserMeal;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;

class UserMealController extends Controller
{
    /**
     * Show all meals of the logged-in user
     */
    public function index()
    {
        $user = Auth::user();
        $meals = $user->meals()->with('recipe')->orderBy('meal_date', 'desc')->get();

       return view('user_meals.index', compact('meals'));

    }

    /**
     * Show form to log a new meal
     */
    public function create()
    {
        $recipes = Recipe::all();
        return view('user_meals.create', compact('recipes'));
    }

    /**
     * Store a new meal
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required|exists:recipes,id',
            'meal_date' => 'required|date',
            'meal_time' => 'nullable|date_format:H:i',
            'servings' => 'required|numeric|min:0.1',
            'note' => 'nullable|string',
        ]);

        $meal = UserMeal::create([
            'user_id' => Auth::id(),
            'recipe_id' => $request->recipe_id,
            'meal_date' => $request->meal_date,
            'meal_time' => $request->meal_time,
            'servings' => $request->servings,
            'note' => $request->note,
        ]);

        return redirect()->route('user_meals.index')->with('success', 'Meal logged successfully!');
    }
   

    /**
     * Show details of a single meal
     */
    public function show(UserMeal $userMeal)
    {
        $userMeal->load('recipe.ingredients.nutrition', 'recipe.ingredients.carbon', 'recipe.totals');
        return view('user_meals.show', compact('userMeal'));
    }
}
