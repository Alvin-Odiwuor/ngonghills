<?php

namespace Database\Seeders;

use App\Models\Reward;
use Illuminate\Database\Seeder;
use Modules\Product\Entities\Product;

class RewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reward::query()->where('description', 'like', 'Seeded reward #%')->delete();

        for ($i = 1; $i <= 100; $i++) {
            $type = fake()->randomElement(['discount', 'free_product', 'voucher', 'points', 'early access']);

            $rewardValue = match ($type) {
                'discount' => (string) fake()->numberBetween(5, 50),
                'free_product' => 'PRD_' . str_pad((string) fake()->numberBetween(1, 100), 4, '0', STR_PAD_LEFT),
                'points' => (string) fake()->numberBetween(50, 1000),
                'early access' => strtoupper(fake()->randomElement(['VIP', 'PRIORITY', 'PREVIEW'])) . '-' . now()->addDays(fake()->numberBetween(7, 90))->format('Ymd'),
                default => 'VOUCHER-' . strtoupper(fake()->bothify('##??##')),
            };

            Reward::create([
                'name' => ucfirst($type) . ' Reward ' . $i,
                'description' => 'Seeded reward #' . $i,
                'points_required' => fake()->numberBetween(100, 5000),
                'reward_type' => $type,
                'reward_value' => $rewardValue,
                'product_id' => fake()->boolean(50) ? Product::query()->inRandomOrder()->value('id') : null,
                'stock' => fake()->boolean(60) ? fake()->numberBetween(10, 400) : null,
                'is_active' => fake()->boolean(85),
                'expires_at' => fake()->boolean(35)
                    ? now()->addDays(fake()->numberBetween(20, 365))->toDateString()
                    : null,
            ]);
        }
    }
}
