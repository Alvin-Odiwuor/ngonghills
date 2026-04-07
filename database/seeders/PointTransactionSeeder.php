<?php

namespace Database\Seeders;

use App\Models\LoyaltyAccount;
use App\Models\PointTransaction;
use Illuminate\Database\Seeder;
use Modules\Sale\Entities\Sale;

class PointTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = LoyaltyAccount::query()->get();

        if ($accounts->isEmpty()) {
            return;
        }

        PointTransaction::query()
            ->where('description', 'like', 'Seeded point transaction #%')
            ->delete();

        for ($i = 1; $i <= 100; $i++) {
            $type = fake()->randomElement(['earn', 'redeem', 'expire', 'adjust']);
            $points = match ($type) {
                'earn' => fake()->numberBetween(10, 250),
                'redeem' => -fake()->numberBetween(10, 180),
                'expire' => -fake()->numberBetween(5, 120),
                default => fake()->boolean() ? fake()->numberBetween(5, 150) : -fake()->numberBetween(5, 150),
            };

            PointTransaction::create([
                'loyalty_account_id' => $accounts->random()->id,
                'sale_id' => fake()->boolean(40) ? Sale::query()->inRandomOrder()->value('id') : null,
                'type' => $type,
                'points' => $points,
                'description' => 'Seeded point transaction #' . $i,
                'expires_at' => in_array($type, ['earn', 'adjust'], true) && fake()->boolean(30)
                    ? now()->addDays(fake()->numberBetween(45, 365))->toDateString()
                    : null,
            ]);
        }
    }
}
