<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'instructions',
        'prep_minutes',
        'servings',
    ];

    // Relationships
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredient')
                    ->withPivot('quantity', 'unit')
                    ->withTimestamps();
    }

    public function totals()
    {
        return $this->hasOne(RecipeTotal::class);
    }

    public function meals()
    {
        return $this->hasMany(UserMeal::class);
    }
    // app/Models/Recipe.php
// app/Models/Recipe.php

public static function suggestForUser($user)
{
    $goals = $user->goals()->where('active', true)->get();

    $recipes = self::with('totals')->get(); // totals must exist

    $suggestions = [];

    foreach ($recipes as $recipe) {
        if (!$recipe->totals) continue; // skip recipes without totals

        $matches = true;

        foreach ($goals as $goal) {
            $value = $recipe->totals->{$goal->nutrient} ?? 0;

            if ($goal->direction === 'max' && $value >= $goal->target_value) {
                $matches = true;
            } elseif ($goal->direction === 'min' && $value <= $goal->target_value) {
                $matches = true;
            } else {
                $matches = false;
                break;
            }
        }

        if ($matches) $suggestions[] = $recipe;
    }

    return collect($suggestions);
}

public function mealPlans()
{
    return $this->hasMany(MealPlan::class);
}

}
