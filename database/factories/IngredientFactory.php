<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $unit = fake()->randomElement(['g', 'ml', 'kg', 'L', 'pcs']);

        return [
            'name' => fake()->unique()->words(2, true),
            'description' => fake()->optional()->sentence(12),
            'unit' => $unit,
            'current_stock' => fake()->randomFloat(3, 0, 500),
            'reorder_level' => fake()->randomFloat(3, 5, 100),
            'cost_per_unit' => fake()->randomFloat(4, 0.05, 250),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }
}
