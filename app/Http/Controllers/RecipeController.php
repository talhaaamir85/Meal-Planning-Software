<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\RecipeIngredient;
use App\Models\RecipeTotal;

class RecipeController extends Controller
{
    /**
     * List all recipes
     */
    public function index()
    {
        $recipes = Recipe::with('ingredients')->get();
        return view('recipes.index', compact('recipes'));
    }

    /**
     * Show form to create a recipe
     */
    public function create()
    {
        $ingredients = Ingredient::all();
        return view('recipes.create', compact('ingredients'));
    }

    /**
     * Store a new recipe
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'prep_minutes' => 'nullable|integer|min:0',
            'servings' => 'required|numeric|min:0.1',
            'ingredients' => 'required|array',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric|min:0',
            'ingredients.*.unit' => 'nullable|string|max:10',
        ]);

        // Create Recipe
        $recipe = Recipe::create([
            'title' => $request->title,
            'instructions' => $request->instructions,
            'prep_minutes' => $request->prep_minutes,
            'servings' => $request->servings,
        ]);

        // Attach Ingredients
        foreach ($request->ingredients as $item) {
            $recipe->ingredients()->attach($item['id'], [
                'quantity' => $item['quantity'],
                'unit' => $item['unit'] ?? null,
            ]);
        }

        // Calculate Recipe Totals
        $this->calculateTotals($recipe);

        return redirect()->route('recipes.index')->with('success', 'Recipe created successfully!');
    }

    /**
     * Show single recipe
     */
    public function show(Recipe $recipe)
    {
        $recipe->load('ingredients.nutrition', 'ingredients.carbon', 'totals');
        return view('recipes.show', compact('recipe'));
    }

    /**
     * 
     * Calculate totals for a recipe yes it 
     */
    public function calculateTotals(Recipe $recipe)
    {
        $totals = [
            'calories' => 0,
            'protein' => 0,
            'carbs' => 0,
            'fat' => 0,
            'fiber' => 0,
            'co2e_kg' => 0,
        ];

        foreach ($recipe->ingredients as $ingredient) {
            $qty_factor = $ingredient->pivot->quantity / $ingredient->nutrition->per_100_unit;
            $totals['calories'] += $ingredient->nutrition->calories_kcal * $qty_factor;
            $totals['protein'] += $ingredient->nutrition->protein_g * $qty_factor;
            $totals['carbs'] += $ingredient->nutrition->carbs_g * $qty_factor;
            $totals['fat'] += $ingredient->nutrition->fat_g * $qty_factor;
            $totals['fiber'] += $ingredient->nutrition->fiber_g * $qty_factor;
            $totals['co2e_kg'] += $ingredient->carbon->co2e_kg * $qty_factor;
        }

        // Save totals
        RecipeTotal::updateOrCreate(
            ['recipe_id' => $recipe->id],
            $totals
        );
    }
}
