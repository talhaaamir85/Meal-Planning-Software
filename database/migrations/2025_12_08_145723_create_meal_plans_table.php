<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meal_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('recipe_id')->constrained()->onDelete('cascade');
            $table->date('date'); // The day this recipe is planned for
            $table->integer('servings')->default(1);
            $table->timestamps();

            $table->unique(['user_id', 'recipe_id', 'date']); // Prevent duplicates
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_plans');
    }
};
