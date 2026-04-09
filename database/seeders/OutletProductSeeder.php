<?php

namespace Database\Seeders;

use App\Models\Outlet;
use App\Models\OutletProduct;
use Illuminate\Database\Seeder;
use Modules\Product\Entities\Product;

class OutletProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $outlets = Outlet::query()->get(['id']);
        $products = Product::query()->where('product_price', '>', 0)->get(['id', 'product_price']);

        if ($outlets->isEmpty() || $products->isEmpty()) {
            return;
        }

        foreach ($outlets as $outlet) {
            $products
                ->shuffle()
                ->take(min(12, $products->count()))
                ->each(function (Product $product) use ($outlet): void {
                    OutletProduct::query()->updateOrCreate(
                        [
                            'outlet_id' => $outlet->id,
                            'product_id' => $product->id,
                        ],
                        [
                            'price' => round((float) $product->product_price * fake()->randomFloat(2, 0.85, 1.35), 4),
                            'status' => fake()->randomElement(['active', 'inactive']),
                        ]
                    );
                });
        }
    }
}
