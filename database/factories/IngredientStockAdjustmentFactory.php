<?php

namespace Database\Factories;

use App\Models\Ingredient;
use App\Models\IngredientPurchase;
use App\Models\Outlet;
use App\Models\ProductionRun;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IngredientStockAdjustment>
 */
class IngredientStockAdjustmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $referenceType = fake()->randomElement([
            null,
            null,
            IngredientPurchase::class,
            ProductionRun::class,
        ]);

        $referenceId = null;

        if ($referenceType === IngredientPurchase::class) {
            $referenceId = IngredientPurchase::query()->inRandomOrder()->value('id');
        }

        if ($referenceType === ProductionRun::class) {
            $referenceId = ProductionRun::query()->inRandomOrder()->value('id');
        }

        return [
            'ingredient_id' => Ingredient::query()->inRandomOrder()->value('id'),
            'outlet_id' => Outlet::query()->inRandomOrder()->value('id'),
            'adjustment_type' => fake()->randomElement(['addition', 'deduction']),
            'quantity' => fake()->randomFloat(3, 0.1, 50),
            'reason' => fake()->randomElement(['purchase', 'wastage', 'spoilage', 'correction', 'return']),
            'reference_id' => $referenceId,
            'reference_type' => $referenceType,
            'notes' => fake()->optional()->sentence(10),
            'adjusted_by' => User::query()->inRandomOrder()->value('id'),
        ];
    }
}
