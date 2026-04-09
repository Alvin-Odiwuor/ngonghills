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
        Schema::create('production_run_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_run_id')->constrained('production_runs')->cascadeOnDelete();
            $table->foreignId('ingredient_id')->constrained('ingredients')->cascadeOnDelete();
            $table->decimal('quantity_used', 15, 3);
            $table->decimal('unit_cost_at_time', 15, 4);
            $table->decimal('total_cost', 15, 4);
            $table->timestamps();

            $table->index(['production_run_id', 'ingredient_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_run_ingredients');
    }
};
