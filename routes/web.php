<?php
use App\Http\Controllers\UserMealController;
use App\Http\Controllers\UserGoalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\IngredientController;
require __DIR__.'/auth.php';

// Recipes
Route::resource('recipes', RecipeController::class);

// Ingredients
Route::resource('ingredients', IngredientController::class);

// User Meals
Route::middleware('auth')->group(function() {
    Route::resource('user_meals', UserMealController::class)->except(['edit', 'update', 'destroy']);
    
    // User Goals
    Route::resource('user_goals', UserGoalController::class)->except(['edit', 'update', 'destroy']);
    Route::post('user_goals/{userGoal}/deactivate', [UserGoalController::class, 'deactivate'])->name('user_goals.deactivate');
});


Route::middleware('auth')->group(function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});
