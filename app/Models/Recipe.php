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
}
