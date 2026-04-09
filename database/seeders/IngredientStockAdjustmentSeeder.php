<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\IngredientStockAdjustment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientStockAdjustmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Ingredient::query()->doesntExist() || User::query()->doesntExist()) {
            $this->command?->warn('Skipping IngredientStockAdjustmentSeeder: ingredients or users are missing.');
            return;
        }

        for ($i = 1; $i <= 150; $i++) {
            DB::transaction(function () {
                $ingredient = Ingredient::query()->inRandomOrder()->lockForUpdate()->first();
                $userId = User::query()->inRandomOrder()->value('id');

                $adjustmentType = fake()->randomElement(['addition', 'deduction']);
                $quantity = fake()->randomFloat(3, 0.1, 15);

                if ($adjustmentType === 'deduction' && (float) $ingredient->current_stock < $quantity) {
                    $adjustmentType = 'addition';
                }

                $signedQuantity = $adjustmentType === 'deduction' ? -1 * $quantity : $quantity;

                $ingredient->update([
                    'current_stock' => (float) $ingredient->current_stock + $signedQuantity,
                ]);

                IngredientStockAdjustment::create([
                    'ingredient_id' => $ingredient->id,
                    'adjustment_type' => $adjustmentType,
                    'quantity' => $quantity,
                    'reason' => fake()->randomElement(['purchase', 'wastage', 'spoilage', 'correction', 'return']),
                    'reference_id' => null,
                    'reference_type' => null,
                    'notes' => 'Seeded adjustment #' . fake()->numberBetween(1, 9999),
                    'adjusted_by' => $userId,
                ]);
            });
        }
    }
}
