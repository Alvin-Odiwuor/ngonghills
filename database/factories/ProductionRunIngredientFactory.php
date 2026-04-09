<?php

namespace Database\Factories;

use App\Models\Ingredient;
use App\Models\ProductionRun;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductionRunIngredient>
 */
class ProductionRunIngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantityUsed = fake()->randomFloat(3, 0.1, 50);
        $unitCost = fake()->randomFloat(4, 0.1, 200);

        return [
            'production_run_id' => ProductionRun::query()->inRandomOrder()->value('id'),
            'ingredient_id' => Ingredient::query()->inRandomOrder()->value('id'),
            'quantity_used' => $quantityUsed,
            'unit_cost_at_time' => $unitCost,
            'total_cost' => $quantityUsed * $unitCost,
        ];
    }
}
