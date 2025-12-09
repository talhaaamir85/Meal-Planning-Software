<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Recipe;
use App\Models\RecipeTotal;
use App\Models\UserGoal;
use App\Models\BiometricEntry;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Create a demo user
        $user = User::factory()->create([
            'name' => 'Talha Amir',
            'email' => 'talha.aamir85@gmail.com',
            'password' => bcrypt('password123'),
        ]);

        // 2. Create recipes with totals
        $recipes = [
            ['title' => 'Grilled Chicken', 'servings' => 1, 'totals' => ['calories'=>200, 'protein'=>10, 'carbs'=>0, 'fat'=>5, 'fiber'=>0, 'co2e_kg'=>0.1]],
            ['title' => 'Chicken & Rice', 'servings' => 1, 'totals' => ['calories'=>467.5, 'protein'=>57, 'carbs'=>60, 'fat'=>10, 'fiber'=>5, 'co2e_kg'=>0.3]],
            ['title' => 'Test Salad', 'servings' => 1, 'totals' => ['calories'=>200, 'protein'=>10, 'carbs'=>20, 'fat'=>5, 'fiber'=>5, 'co2e_kg'=>0.2]],
        ];

        foreach ($recipes as $r) {
            $recipe = Recipe::create([
                'title' => $r['title'],
                'servings' => $r['servings'],
            ]);
            $recipe->totals()->create($r['totals']);
        }

        // 3. Add user goals
        $user->goals()->createMany([
            [
                'nutrient' => 'protein',
                'target_value' => 20,
                'direction' => 'max',
                'period' => 'day',
                'active' => true,
            ],
            [
                'nutrient' => 'calories',
                'target_value' => 300,
                'direction' => 'min',
                'period' => 'day',
                'active' => true,
            ],
        ]);

        // 4. Add biometric entries
        BiometricEntry::create([
            'user_id' => $user->id,
            'recorded_at' => now()->subDays(5),
            'weight_kg' => 70.5,
            'blood_pressure_systolic' => 120,
            'blood_pressure_diastolic' => 80,
            'heart_rate' => 72,
            'note' => 'Feeling good today.',
        ]);

        BiometricEntry::create([
            'user_id' => $user->id,
            'recorded_at' => now(),
            'weight_kg' => 69.8,
            'blood_pressure_systolic' => 130,
            'blood_pressure_diastolic' => 85,
            'heart_rate' => 75,
            'note' => 'A bit stressed.',
        ]);
    }
}
