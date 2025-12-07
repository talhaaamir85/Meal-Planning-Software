<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\NutritionValue;
use App\Models\CarbonValue;

class IngredientController extends Controller
{
    /**
     * List all ingredients
     */
    public function index()
    {
        $ingredients = Ingredient::with('nutrition', 'carbon')->get();
        return view('ingredients.index', compact('ingredients'));
    }

    /**
     * Show form to create ingredient
     */
    public function create()
    {
        return view('ingredients.create');
    }

    /**
     * Store new ingredient
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:ingredients,name',
            'unit' => 'nullable|string|max:10',
            'nutrition.calories_kcal' => 'nullable|numeric|min:0',
            'nutrition.protein_g' => 'nullable|numeric|min:0',
            'nutrition.carbs_g' => 'nullable|numeric|min:0',
            'nutrition.fat_g' => 'nullable|numeric|min:0',
            'nutrition.fiber_g' => 'nullable|numeric|min:0',
            'nutrition.sugar_g' => 'nullable|numeric|min:0',
            'nutrition.sodium_mg' => 'nullable|numeric|min:0',
            'carbon.co2e_kg' => 'nullable|numeric|min:0',
        ]);

        $ingredient = Ingredient::create([
            'name' => $request->name,
            'unit' => $request->unit,
        ]);

        // Nutrition
        $ingredient->nutrition()->create([
            'per_100_unit' => 100,
            'calories_kcal' => $request->nutrition['calories_kcal'] ?? 0,
            'protein_g' => $request->nutrition['protein_g'] ?? 0,
            'carbs_g' => $request->nutrition['carbs_g'] ?? 0,
            'fat_g' => $request->nutrition['fat_g'] ?? 0,
            'fiber_g' => $request->nutrition['fiber_g'] ?? 0,
            'sugar_g' => $request->nutrition['sugar_g'] ?? 0,
            'sodium_mg' => $request->nutrition['sodium_mg'] ?? 0,
        ]);

        // Carbon
        $ingredient->carbon()->create([
            'per_100_unit' => 100,
            'co2e_kg' => $request->carbon['co2e_kg'] ?? 0,
        ]);

        return redirect()->route('ingredients.index')->with('success', 'Ingredient created successfully!');
    }

    /**
     * Show ingredient details
     */
    public function show(Ingredient $ingredient)
    {
        $ingredient->load('nutrition', 'carbon', 'recipes');
        return view('ingredients.show', compact('ingredient'));
    }
}
