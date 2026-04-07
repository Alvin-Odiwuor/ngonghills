<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\Entities\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reward>
 */
class RewardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['discount', 'free_product', 'voucher', 'points', 'early access']);
        $rewardValue = match ($type) {
            'discount' => (string) fake()->numberBetween(5, 50),
            'free_product' => 'PRD_' . str_pad((string) fake()->numberBetween(1, 100), 4, '0', STR_PAD_LEFT),
            'points' => (string) fake()->numberBetween(50, 1000),
            'early access' => strtoupper(fake()->randomElement(['VIP', 'PRIORITY', 'PREVIEW'])) . '-' . now()->addDays(fake()->numberBetween(7, 90))->format('Ymd'),
            default => 'VCH-' . strtoupper(fake()->bothify('??###??')),
        };

        return [
            'name' => ucfirst($type) . ' Reward ' . fake()->numberBetween(1, 999),
            'description' => fake()->sentence(12),
            'points_required' => fake()->numberBetween(100, 5000),
            'reward_type' => $type,
            'reward_value' => $rewardValue,
            'product_id' => fake()->boolean(50) ? Product::query()->inRandomOrder()->value('id') : null,
            'stock' => fake()->boolean(60) ? fake()->numberBetween(10, 500) : null,
            'is_active' => fake()->boolean(85),
            'expires_at' => fake()->boolean(40) ? now()->addDays(fake()->numberBetween(15, 365))->toDateString() : null,
        ];
    }
}
