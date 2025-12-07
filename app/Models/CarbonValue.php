<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarbonValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'ingredient_id',
        'per_100_unit',
        'co2e_kg',
    ];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}
