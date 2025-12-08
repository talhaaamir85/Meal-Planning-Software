<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use App\Models\RecipeTotal;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecipeSuggestionTest extends TestCase
{
    use RefreshDatabase; // Resets the database for every test

    public function test_user_can_see_suggested_recipes()
    {
        // Create a user
        $user = User::factory()->create();

        // Add a goal for the user
        $user->goals()->create([
            'nutrient' => 'protein',
            'target_value' => 5,
            'direction' => 'max',
            'period' => 'day',
            'active' => true,
        ]);

        // Create a recipe
        $recipe = Recipe::factory()->create(['title' => 'Grilled Chicken']);

        // Attach totals to the recipe
        $recipe->totals()->create(
            RecipeTotal::factory()->make([
                'calories' => 200,
                'protein' => 10,
                'carbs' => 0,
                'fat' => 5,
                'fiber' => 0,
                'co2e_kg' => 0.1,
            ])->toArray()
        );

        // Create another recipe
        $recipe2 = Recipe::factory()->create(['title' => 'Chicken & Rice']);
        $recipe2->totals()->create(
            RecipeTotal::factory()->make([
                'calories' => 300,
                'protein' => 15,
                'carbs' => 40,
                'fat' => 8,
                'fiber' => 2,
                'co2e_kg' => 1.2,
            ])->toArray()
        );

        // Visit the recipe suggestions page as the user
        $response = $this->actingAs($user)->get(route('recipes.suggestions'));

        // Assertions
        $response->assertStatus(200);
        $response->assertSee('Suggested Recipes');
        $response->assertSee('Grilled Chicken');
        $response->assertSee('Chicken & Rice');
    }
}
