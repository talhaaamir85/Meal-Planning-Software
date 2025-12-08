<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RecipeTotal;

class RecipeTotalFactory extends Factory
{
    protected $model = RecipeTotal::class;

    public function definition()
    {
        return [
            'recipe_id' => null, // you can set this in the test when creating
            'calories' => $this->faker->numberBetween(100, 800),
            'protein' => $this->faker->numberBetween(0, 50),
            'carbs' => $this->faker->numberBetween(0, 100),
            'fat' => $this->faker->numberBetween(0, 30),
            'fiber' => $this->faker->numberBetween(0, 20),
            'co2e_kg' => $this->faker->randomFloat(1, 0.1, 10),
        ];
    }
}
