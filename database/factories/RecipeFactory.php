<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\Entities\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::query()->inRandomOrder()->value('id'),
            'name' => fake()->unique()->words(3, true),
            'description' => fake()->optional()->sentence(12),
            'yield_quantity' => fake()->randomFloat(3, 1, 100),
            'notes' => fake()->optional()->sentence(15),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }
}
