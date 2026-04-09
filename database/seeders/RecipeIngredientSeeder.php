<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use Illuminate\Database\Seeder;

class RecipeIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Recipe::query()->doesntExist() || Ingredient::query()->doesntExist()) {
            $this->command?->warn('Skipping RecipeIngredientSeeder: recipes or ingredients are missing.');
            return;
        }

        RecipeIngredient::factory()->count(150)->create();
    }
}
