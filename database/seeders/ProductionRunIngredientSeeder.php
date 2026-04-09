<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\ProductionRun;
use App\Models\ProductionRunIngredient;
use Illuminate\Database\Seeder;

class ProductionRunIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (ProductionRun::query()->doesntExist() || Ingredient::query()->doesntExist()) {
            $this->command?->warn('Skipping ProductionRunIngredientSeeder: production runs or ingredients are missing.');
            return;
        }

        ProductionRunIngredient::factory()->count(180)->create();
    }
}
