<?php

namespace Database\Seeders;

use App\Models\LoyaltyAccount;
use Illuminate\Database\Seeder;
use Modules\People\Entities\Customer;

class LoyaltyAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::query()->limit(100)->get();

        foreach ($customers as $customer) {
            $earned = (int) fake()->numberBetween(100, 15000);
            $redeemed = (int) fake()->numberBetween(0, min(10000, $earned));
            $balance = $earned - $redeemed;

            $tier = 'Bronze';
            if ($earned >= 10000) {
                $tier = 'Gold';
            } elseif ($earned >= 5000) {
                $tier = 'Silver';
            }

            LoyaltyAccount::updateOrCreate([
                'customer_id' => $customer->id,
            ], [
                'points_balance' => $balance,
                'total_points_earned' => $earned,
                'total_points_redeemed' => $redeemed,
                'tier' => $tier,
                'status' => fake()->randomElement(['active', 'active', 'active', 'suspended']),
            ]);
        }
    }
}
