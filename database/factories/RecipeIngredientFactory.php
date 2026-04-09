<?php

namespace Database\Factories;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RecipeIngredient>
 */
class RecipeIngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ingredient = Ingredient::query()->inRandomOrder()->first();

        return [
            'recipe_id' => Recipe::query()->inRandomOrder()->value('id'),
            'ingredient_id' => $ingredient?->id,
            'quantity_required' => fake()->randomFloat(3, 0.1, 25),
            'unit' => $ingredient?->unit ?? fake()->randomElement(['g', 'ml', 'kg', 'L', 'pcs']),
            'notes' => fake()->optional()->sentence(10),
        ];
    }
}
