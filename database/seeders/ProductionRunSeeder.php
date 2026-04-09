<?php

namespace Database\Seeders;

use App\Models\Outlet;
use App\Models\ProductionRun;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Product\Entities\Product;

class ProductionRunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Recipe::query()->doesntExist() || Product::query()->doesntExist() || User::query()->doesntExist() || Outlet::query()->doesntExist()) {
            $this->command?->warn('Skipping ProductionRunSeeder: recipes, products, users, or outlets are missing.');
            return;
        }

        ProductionRun::factory()->count(100)->create();
    }
}
