<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'ingredient_id',
        'per_100_unit',
        'calories_kcal',
        'protein_g',
        'carbs_g',
        'fat_g',
        'fiber_g',
        'sugar_g',
        'sodium_mg',
    ];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}
