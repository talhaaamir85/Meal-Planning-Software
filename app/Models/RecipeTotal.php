<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeTotal extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_id',
        'calories',
        'protein',
        'carbs',
        'fat',
        'fiber',
        'co2e_kg',
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
