<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserMealController;
use App\Http\Controllers\UserGoalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\BiometricEntryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MealPlanController;
// Authentication scaffolding
require __DIR__.'/auth.php';

// =======================================
// Recipes
// =======================================
Route::middleware('auth')->group(function () {
    Route::get('recipes/suggestions', [RecipeController::class, 'suggestions'])->name('recipes.suggestions');
    Route::resource('recipes', RecipeController::class);
});


// =======================================
// Ingredients
// =======================================
Route::middleware('auth')->group(function () {
    Route::resource('ingredients', IngredientController::class);
});

// =======================================
// User Meals
// =======================================
Route::middleware('auth')->group(function () {
    Route::resource('user_meals', UserMealController::class)->except(['edit', 'update', 'destroy']);
});

// =======================================
// User Goals
// =======================================
Route::middleware('auth')->group(function() {
    Route::resource('user_goals', UserGoalController::class)->except(['show', 'destroy']);
    Route::post('user_goals/{userGoal}/deactivate', [UserGoalController::class, 'deactivate'])->name('user_goals.deactivate');
    Route::put('user_goals/update', [UserGoalController::class, 'update'])->name('user_goals.update_goals');
});



// =======================================
// Dashboard (home)
// =======================================
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});

// =======================================
// Optional Profile Route
// =======================================

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware('auth')->group(function() {
    Route::resource('biometric_entries', BiometricEntryController::class);
});

Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::get('/meal_plans', [MealPlanController::class, 'index'])->name('meal_plans.index');
    Route::get('/meal_plans/create', [MealPlanController::class, 'create'])->name('meal_plans.create');
    Route::post('/meal_plans', [MealPlanController::class, 'store'])->name('meal_plans.store');
    Route::delete('/meal_plans/{mealPlan}', [MealPlanController::class, 'destroy'])->name('meal_plans.destroy');
});
