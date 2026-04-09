<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Outlet;
use App\Models\OutletIngredientStock;
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
        if (Ingredient::query()->doesntExist() || Outlet::query()->doesntExist() || User::query()->doesntExist()) {
            $this->command?->warn('Skipping IngredientStockAdjustmentSeeder: ingredients, outlets, or users are missing.');
            return;
        }

        for ($i = 1; $i <= 150; $i++) {
            DB::transaction(function () {
                $ingredient = Ingredient::query()->inRandomOrder()->lockForUpdate()->first();
                $outlet = Outlet::query()->where('status', 'active')->inRandomOrder()->first() ?? Outlet::query()->inRandomOrder()->first();
                $userId = User::query()->inRandomOrder()->value('id');

                if (! $outlet) {
                    return;
                }

                $outletStock = OutletIngredientStock::query()
                    ->where('outlet_id', $outlet->id)
                    ->where('ingredient_id', $ingredient->id)
                    ->lockForUpdate()
                    ->first();

                if (! $outletStock) {
                    OutletIngredientStock::query()->create([
                        'outlet_id' => $outlet->id,
                        'ingredient_id' => $ingredient->id,
                        'current_stock' => 0,
                    ]);

                    $outletStock = OutletIngredientStock::query()
                        ->where('outlet_id', $outlet->id)
                        ->where('ingredient_id', $ingredient->id)
                        ->lockForUpdate()
                        ->first();
                }

                $adjustmentType = fake()->randomElement(['addition', 'deduction']);
                $quantity = fake()->randomFloat(3, 0.1, 15);

                if ($adjustmentType === 'deduction' && ((float) $ingredient->current_stock < $quantity || (float) $outletStock->current_stock < $quantity)) {
                    $adjustmentType = 'addition';
                }

                $signedQuantity = $adjustmentType === 'deduction' ? -1 * $quantity : $quantity;

                $ingredient->update([
                    'current_stock' => (float) $ingredient->current_stock + $signedQuantity,
                ]);

                $outletStock->update([
                    'current_stock' => (float) $outletStock->current_stock + $signedQuantity,
                ]);

                IngredientStockAdjustment::create([
                    'ingredient_id' => $ingredient->id,
                    'outlet_id' => $outlet->id,
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
