<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ingredient;
use App\Models\NutritionValue;
use App\Models\CarbonValue;
use App\Models\Recipe;
use App\Models\UserMeal;
use App\Models\UserGoal;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        // Get the first user (assumes you have at least 1 user)
        $user = User::first();
        if (!$user) {
            $this->command->info('No users found. Create at least one user first.');
            return;
        }

        $this->command->info('Seeding demo ingredients...');

        // Ingredients
        $ingredientsData = [
            ['name' => 'Chicken Breast', 'unit' => 'g', 'nutrition' => ['calories_kcal'=>165,'protein_g'=>31,'carbs_g'=>0,'fat_g'=>3.6,'fiber_g'=>0,'sugar_g'=>0,'sodium_mg'=>74],'carbon'=>6.9],
            ['name' => 'Rice', 'unit' => 'g', 'nutrition' => ['calories_kcal'=>130,'protein_g'=>2.4,'carbs_g'=>28,'fat_g'=>0.3,'fiber_g'=>0.4,'sugar_g'=>0,'sodium_mg'=>1],'carbon'=>2.7],
            ['name' => 'Broccoli', 'unit' => 'g', 'nutrition' => ['calories_kcal'=>34,'protein_g'=>2.8,'carbs_g'=>7,'fat_g'=>0.4,'fiber_g'=>2.6,'sugar_g'=>1.7,'sodium_mg'=>33],'carbon'=>0.5],
        ];

        $ingredients = [];

        foreach ($ingredientsData as $data) {
            $ingredient = Ingredient::firstOrCreate(['name'=>$data['name']], ['unit'=>$data['unit']]);

            // Nutrition
            if (!$ingredient->nutrition) {
                $ingredient->nutrition()->create(array_merge(['per_100_unit'=>100], $data['nutrition']));
            }

            // Carbon
            if (!$ingredient->carbon) {
                $ingredient->carbon()->create(['per_100_unit'=>100,'co2e_kg'=>$data['carbon']]);
            }

            $ingredients[$data['name']] = $ingredient;
        }

        $this->command->info('Seeding demo recipes...');

        // Recipes
        $recipe1 = Recipe::firstOrCreate(['title'=>'Grilled Chicken'], ['servings'=>1]);
        $recipe1->ingredients()->syncWithoutDetaching([
            $ingredients['Chicken Breast']->id => ['quantity'=>150,'unit'=>'g'],
            $ingredients['Broccoli']->id => ['quantity'=>100,'unit'=>'g']
        ]);

        $recipe2 = Recipe::firstOrCreate(['title'=>'Chicken & Rice'], ['servings'=>1]);
        $recipe2->ingredients()->syncWithoutDetaching([
            $ingredients['Chicken Breast']->id => ['quantity'=>100,'unit'=>'g'],
            $ingredients['Rice']->id => ['quantity'=>100,'unit'=>'g']
        ]);

        $this->command->info('Seeding demo meals...');

        // Meals for user
        UserMeal::firstOrCreate(
            ['user_id'=>$user->id,'recipe_id'=>$recipe1->id,'meal_date'=>now()->toDateString()],
            ['servings'=>1]
        );

        UserMeal::firstOrCreate(
            ['user_id'=>$user->id,'recipe_id'=>$recipe2->id,'meal_date'=>now()->toDateString()],
            ['servings'=>1]
        );

        $this->command->info('Seeding demo goals...');

        // Goals
        $goalsData = [
            ['nutrient'=>'calories','target_value'=>500,'unit'=>'kcal','direction'=>'max','period'=>'day'],
            ['nutrient'=>'protein','target_value'=>50,'unit'=>'g','direction'=>'min','period'=>'day'],
            ['nutrient'=>'fiber','target_value'=>30,'unit'=>'g','direction'=>'min','period'=>'day'],
        ];

        foreach ($goalsData as $goal) {
            UserGoal::firstOrCreate(
                ['user_id'=>$user->id,'nutrient'=>$goal['nutrient']],
                array_merge($goal,['active'=>true])
            );
        }

        $this->command->info('Demo data seeding completed!');
    }
}
