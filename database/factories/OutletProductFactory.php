<?php

namespace Database\Factories;

use App\Models\Outlet;
use Modules\Product\Entities\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OutletProduct>
 */
class OutletProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::query()->inRandomOrder()->first();
        $basePrice = $product ? (float) $product->product_price : fake()->randomFloat(4, 5, 300);

        return [
            'outlet_id' => Outlet::query()->inRandomOrder()->value('id') ?? Outlet::factory()->create()->id,
            'product_id' => $product?->id ?? Product::query()->inRandomOrder()->value('id'),
            'price' => round($basePrice * fake()->randomFloat(2, 0.8, 1.35), 4),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }
}
