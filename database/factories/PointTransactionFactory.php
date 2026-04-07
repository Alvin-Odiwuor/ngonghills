<?php

namespace Database\Factories;

use App\Models\LoyaltyAccount;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Purchase\Entities\Purchase;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PointTransaction>
 */
class PointTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['earn', 'redeem', 'expire', 'adjust']);
        $points = match ($type) {
            'earn' => fake()->numberBetween(10, 200),
            'redeem' => -fake()->numberBetween(10, 150),
            'expire' => -fake()->numberBetween(5, 100),
            default => fake()->boolean() ? fake()->numberBetween(5, 120) : -fake()->numberBetween(5, 120),
        };

        return [
            'loyalty_account_id' => LoyaltyAccount::query()->inRandomOrder()->value('id') ?? LoyaltyAccount::factory()->create()->id,
            'order_id' => fake()->boolean(45) ? Purchase::query()->inRandomOrder()->value('id') : null,
            'type' => $type,
            'points' => $points,
            'description' => fake()->sentence(8),
            'expires_at' => in_array($type, ['earn', 'adjust'], true) && fake()->boolean(35)
                ? now()->addDays(fake()->numberBetween(30, 365))->toDateString()
                : null,
        ];
    }
}
