<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Recipe;

class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'instructions' => $this->faker->sentence(),
            'prep_minutes' => $this->faker->numberBetween(5, 60),
            'servings' => $this->faker->numberBetween(1, 4),
        ];
    }
}
