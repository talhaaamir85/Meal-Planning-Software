<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nutrition_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingredient_id')->constrained('ingredients')->onDelete('cascade');
            $table->float('per_100_unit')->default(100);   // Amount per 100 units
            $table->float('calories_kcal')->default(0);
            $table->float('protein_g')->default(0);
            $table->float('carbs_g')->default(0);
            $table->float('fat_g')->default(0);
            $table->float('fiber_g')->default(0);
            $table->float('sugar_g')->default(0);
            $table->float('sodium_mg')->default(0);
            $table->timestamps();

            $table->unique('ingredient_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutrition_values');
    }
};
