<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\Entities\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductionRun>
 */
class ProductionRunFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['planned', 'in-progress', 'completed', 'cancelled'];

        return [
            'recipe_id' => Recipe::query()->inRandomOrder()->value('id'),
            'product_id' => Product::query()->inRandomOrder()->value('id'),
            'quantity_produced' => fake()->randomFloat(3, 1, 500),
            'production_date' => fake()->dateTimeBetween('-3 months', '+1 month')->format('Y-m-d'),
            'batch_number' => 'BATCH-' . strtoupper(fake()->bothify('###??###')),
            'notes' => fake()->optional()->sentence(12),
            'produced_by' => User::query()->inRandomOrder()->value('id'),
            'status' => fake()->randomElement($statuses),
        ];
    }
}
