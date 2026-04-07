<?php

namespace Database\Factories;

use App\Models\LoyaltyAccount;
use App\Models\Reward;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Redemption>
 */
class RedemptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $reward = Reward::query()->inRandomOrder()->first();

        return [
            'loyalty_account_id' => LoyaltyAccount::query()->inRandomOrder()->value('id'),
            'reward_id' => $reward?->id,
            'points_used' => $reward?->points_required ?? $this->faker->numberBetween(50, 500),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected', 'used']),
            'redeemed_at' => $this->faker->optional(0.8)->dateTimeBetween('-6 months', 'now'),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
