<?php

namespace Modules\Quotation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Product;
use Modules\Quotation\Entities\Quotation;
use Modules\Quotation\Entities\QuotationDetails;

class QuotationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $customers = Customer::query()->get();
        $products = Product::query()->get();

        if ($customers->isEmpty() || $products->isEmpty()) {
            return;
        }

        // Remove previous seeded quotations; details are deleted via cascade.
        Quotation::query()->where('note', 'like', 'Seeded quotation%')->delete();

        $statuses = ['Pending', 'Sent'];

        for ($i = 1; $i <= 100; $i++) {
            $customer = $customers->random();
            $status = fake()->randomElement($statuses);
            $quotationDate = now()->subDays(fake()->numberBetween(0, 120))->toDateString();

            $selected = $products->random(min(fake()->numberBetween(1, 4), $products->count()));
            if (!($selected instanceof \Illuminate\Support\Collection)) {
                $selected = collect([$selected]);
            }

            $lineItems = [];
            $baseTotal = 0.0;

            foreach ($selected as $product) {
                $unitPrice = max(1, round((float) $product->product_price, 2));
                $quantity = fake()->numberBetween(1, 5);
                $subTotal = round($unitPrice * $quantity, 2);
                $baseTotal += $subTotal;

                $lineItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'sub_total' => $subTotal,
                ];
            }

            $discountPercentage = fake()->numberBetween(0, 10);
            $discountAmount = round($baseTotal * ($discountPercentage / 100), 2);
            $taxPercentage = fake()->numberBetween(0, 10);
            $taxableAmount = max(0, $baseTotal - $discountAmount);
            $taxAmount = round($taxableAmount * ($taxPercentage / 100), 2);
            $shippingAmount = round(fake()->randomFloat(2, 0, 35), 2);
            $totalAmount = round($taxableAmount + $taxAmount + $shippingAmount, 2);

            $quotation = Quotation::create([
                'date' => $quotationDate,
                'customer_id' => $customer->id,
                'customer_name' => $customer->customer_name,
                'tax_percentage' => $taxPercentage,
                'tax_amount' => (int) round($taxAmount * 100),
                'discount_percentage' => $discountPercentage,
                'discount_amount' => (int) round($discountAmount * 100),
                'shipping_amount' => (int) round($shippingAmount * 100),
                'total_amount' => (int) round($totalAmount * 100),
                'status' => $status,
                'note' => 'Seeded quotation #' . $i,
            ]);

            foreach ($lineItems as $item) {
                $product = $item['product'];
                $quantity = $item['quantity'];
                $unitPrice = $item['unit_price'];
                $subTotal = $item['sub_total'];

                QuotationDetails::create([
                    'quotation_id' => $quotation->id,
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'product_code' => $product->product_code ?? ('PRD-' . $product->id),
                    'quantity' => $quantity,
                    'price' => (int) round($unitPrice * 100),
                    'unit_price' => (int) round($unitPrice * 100),
                    'sub_total' => (int) round($subTotal * 100),
                    'product_discount_amount' => 0,
                    'product_discount_type' => 'fixed',
                    'product_tax_amount' => 0,
                ]);
            }
        }
    }
}
