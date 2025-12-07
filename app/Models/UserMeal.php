<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMeal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recipe_id',
        'meal_date',
        'meal_time',
        'servings',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
    public function store(Request $request)
{
    UserMeal::create([
        'user_id' => auth()->id(),
        'recipe_id' => $request->recipe_id,
        'meal_date' => $request->meal_date,
    ]);

    return redirect()->route('user_meals.index');
}

}
