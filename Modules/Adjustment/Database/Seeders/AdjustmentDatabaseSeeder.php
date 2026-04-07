<?php

namespace Modules\Adjustment\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Adjustment\Entities\AdjustedProduct;
use Modules\Adjustment\Entities\Adjustment;
use Modules\Product\Entities\Product;

class AdjustmentDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $products = Product::query()->inRandomOrder()->get();

        if ($products->isEmpty()) {
            return;
        }

        // Remove previous seeded adjustments so reruns do not duplicate data.
        Adjustment::query()
            ->where('note', 'like', 'Seeded adjustment%')
            ->delete();

        $adjustmentsToCreate = 30;

        for ($i = 1; $i <= $adjustmentsToCreate; $i++) {
            $adjustment = Adjustment::create([
                'date' => now()->subDays(fake()->numberBetween(0, 90))->toDateString(),
                'note' => 'Seeded adjustment #' . $i,
            ]);

            $items = $products->random(min(fake()->numberBetween(1, 4), $products->count()));
            if (!($items instanceof \Illuminate\Support\Collection)) {
                $items = collect([$items]);
            }

            foreach ($items as $product) {
                $type = $product->product_quantity > 10
                    ? fake()->randomElement(['add', 'sub'])
                    : 'add';

                $maxSubtraction = max(1, min(8, $product->product_quantity));
                $quantity = $type === 'sub'
                    ? fake()->numberBetween(1, $maxSubtraction)
                    : fake()->numberBetween(1, 12);

                AdjustedProduct::create([
                    'adjustment_id' => $adjustment->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'type' => $type,
                ]);

                if ($type === 'add') {
                    $product->update([
                        'product_quantity' => $product->product_quantity + $quantity,
                    ]);
                } else {
                    $product->update([
                        'product_quantity' => max(0, $product->product_quantity - $quantity),
                    ]);
                }
            }
        }
    }
}
