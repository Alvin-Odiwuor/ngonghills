<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\IngredientPurchase;
use App\Models\Outlet;
use Illuminate\Database\Seeder;
use Modules\People\Entities\Supplier;

class IngredientPurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Ingredient::query()->doesntExist() || Supplier::query()->doesntExist() || Outlet::query()->doesntExist()) {
            $this->command?->warn('Skipping IngredientPurchaseSeeder: ingredients, suppliers, or outlets are missing.');
            return;
        }

        IngredientPurchase::factory()->count(100)->create();
    }
}
