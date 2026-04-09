<?php

namespace Database\Factories;

use App\Models\Ingredient;
use App\Models\Outlet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OutletIngredientStock>
 */
class OutletIngredientStockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'outlet_id' => Outlet::query()->inRandomOrder()->value('id'),
            'ingredient_id' => Ingredient::query()->inRandomOrder()->value('id'),
            'current_stock' => fake()->randomFloat(3, 0, 500),
        ];
    }
}
