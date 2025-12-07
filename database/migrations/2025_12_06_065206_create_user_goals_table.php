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
        Schema::create('user_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nutrient');           // e.g., calories, protein, fiber
            $table->float('target_value');
            $table->string('unit')->nullable();    // e.g., kcal, g
            $table->enum('direction', ['min','max'])->default('min');
            $table->enum('period', ['day','week'])->default('day');
            $table->boolean('active')->default(true);
            $table->float('weight')->default(1);  // priority weight
            $table->timestamps();

            $table->index(['user_id','nutrient']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_goals');
    }
};
