<?php
namespace App\Policies;

use App\Models\MealPlan;
use App\Models\User;

class MealPlanPolicy
{
    public function delete(User $user, MealPlan $mealPlan)
    {
        return $user->id === $mealPlan->user_id;
    }
}
