<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Setting\Entities\Unit;

class ProductDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $categories = [
            'Rooms & Accommodations',
            'Food & Beverage',
            'Spa & Wellness',
            'Sports & Recreation',
            'Business & Events',
            'Concierge & Guest Services',
            'Transportation',
            'Retail & Boutique',
            'Entertainment & Leisure',
            'Health & Medical Services',
            'Childcare & Family Services',
            'Technology & Connectivity',
            'Laundry & Housekeeping',
            'Security & Privacy Services',
            'Membership & Loyalty Programs',
        ];

        $categoryIds = [];
        foreach ($categories as $index => $categoryName) {
            $category = Category::updateOrCreate([
                'category_code' => 'CA_' . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
            ], [
                'category_name' => $categoryName,
            ]);

            $categoryIds[] = $category->id;
        }

        Unit::firstOrCreate([
            'short_name' => 'PC',
        ], [
            'name' => 'Piece',
            'operator' => '*',
            'operation_value' => 1
        ]);

        for ($i = 1; $i <= 100; $i++) {
            $productCode = 'PRD_' . str_pad((string) $i, 4, '0', STR_PAD_LEFT);

            Product::updateOrCreate([
                'product_code' => $productCode,
            ], [
                'category_id' => fake()->randomElement($categoryIds),
                'product_name' => 'Sample Product ' . $i,
                'product_barcode_symbology' => 'C128',
                'product_quantity' => fake()->numberBetween(20, 500),
                'product_cost' => fake()->randomFloat(2, 5, 200),
                'product_price' => fake()->randomFloat(2, 201, 500),
                'product_unit' => 'PC',
                'product_stock_alert' => fake()->numberBetween(3, 20),
                'product_order_tax' => fake()->numberBetween(0, 18),
                'product_tax_type' => fake()->numberBetween(1, 2),
                'product_note' => Str::limit(fake()->sentence(12), 120),
            ]);
        }
    }
}
