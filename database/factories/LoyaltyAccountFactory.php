<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\People\Entities\Customer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LoyaltyAccount>
 */
class LoyaltyAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $earned = (int) fake()->numberBetween(100, 15000);
        $redeemed = (int) fake()->numberBetween(0, min(10000, $earned));
        $balance = $earned - $redeemed;

        return [
            'customer_id' => Customer::query()->inRandomOrder()->value('id') ?? Customer::factory()->create()->id,
            'points_balance' => $balance,
            'total_points_earned' => $earned,
            'total_points_redeemed' => $redeemed,
            'tier' => fake()->randomElement(['Bronze', 'Silver', 'Gold']),
            'status' => fake()->randomElement(['active', 'suspended']),
        ];
    }
}
