<?php

namespace Database\Factories;

use App\Models\Ingredient;
use App\Models\Outlet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\People\Entities\Supplier;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IngredientPurchase>
 */
class IngredientPurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = fake()->randomFloat(3, 1, 200);
        $unitCost = fake()->randomFloat(4, 0.1, 500);

        return [
            'ingredient_id' => Ingredient::query()->inRandomOrder()->value('id'),
            'supplier_id' => Supplier::query()->inRandomOrder()->value('id'),
            'outlet_id' => Outlet::query()->inRandomOrder()->value('id'),
            'quantity' => $quantity,
            'unit_cost' => $unitCost,
            'total_cost' => $quantity * $unitCost,
            'purchase_date' => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'invoice_number' => 'ING-INV-' . strtoupper(fake()->bothify('###??##')),
            'notes' => fake()->optional()->sentence(10),
        ];
    }
}
