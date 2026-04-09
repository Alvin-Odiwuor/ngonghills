<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Seeder;
use Modules\Product\Entities\Product;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Product::query()->doesntExist()) {
            $this->command?->warn('Skipping RecipeSeeder: products are missing.');
            return;
        }

        Recipe::factory()->count(100)->create();
    }
}
