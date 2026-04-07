<?php

namespace Database\Seeders;

use App\Models\LoyaltyAccount;
use App\Models\Redemption;
use App\Models\Reward;
use Illuminate\Database\Seeder;

class RedemptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (LoyaltyAccount::query()->doesntExist() || Reward::query()->doesntExist()) {
            $this->command?->warn('Skipping RedemptionSeeder: loyalty accounts or rewards are missing.');
            return;
        }

        Redemption::factory()->count(100)->create();
    }
}
