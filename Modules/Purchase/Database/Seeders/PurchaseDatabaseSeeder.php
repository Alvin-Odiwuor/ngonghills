<?php

namespace Modules\Purchase\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\People\Entities\Supplier;
use Modules\Product\Entities\Product;
use Modules\Purchase\Entities\Purchase;
use Modules\Purchase\Entities\PurchaseDetail;
use Modules\Purchase\Entities\PurchasePayment;

class PurchaseDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $suppliers = Supplier::query()->get();
        $products = Product::query()->get();

        if ($suppliers->isEmpty() || $products->isEmpty()) {
            return;
        }

        // Remove previous seeded purchases; details and payments are deleted by cascade.
        Purchase::query()->where('note', 'like', 'Seeded purchase%')->delete();

        $statuses = ['Pending', 'Ordered', 'Completed'];
        $paymentMethods = ['Cash', 'Credit Card', 'Bank Transfer', 'Cheque', 'Other'];

        for ($i = 1; $i <= 100; $i++) {
            $supplier = $suppliers->random();
            $status = fake()->randomElement($statuses);
            $paymentMethod = fake()->randomElement($paymentMethods);
            $purchaseDate = now()->subDays(fake()->numberBetween(0, 120))->toDateString();

            $selected = $products->random(min(fake()->numberBetween(1, 4), $products->count()));
            if (!($selected instanceof \Illuminate\Support\Collection)) {
                $selected = collect([$selected]);
            }

            $lineItems = [];
            $baseTotal = 0.0;

            foreach ($selected as $product) {
                $unitPrice = max(1, round((float) $product->product_cost, 2));
                $quantity = fake()->numberBetween(1, 10);
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

            $paymentMode = fake()->randomElement(['Unpaid', 'Partial', 'Paid']);
            if ($paymentMode === 'Unpaid') {
                $paidAmount = 0.0;
                $paymentStatus = 'Unpaid';
            } elseif ($paymentMode === 'Paid') {
                $paidAmount = $totalAmount;
                $paymentStatus = 'Paid';
            } else {
                $paidAmount = round(fake()->randomFloat(2, 1, max(1, $totalAmount - 1)), 2);
                $paidAmount = min($paidAmount, $totalAmount);
                $paymentStatus = $paidAmount >= $totalAmount ? 'Paid' : 'Partial';
            }

            $dueAmount = round($totalAmount - $paidAmount, 2);

            $purchase = Purchase::create([
                'date' => $purchaseDate,
                'supplier_id' => $supplier->id,
                'supplier_name' => $supplier->supplier_name,
                'tax_percentage' => $taxPercentage,
                'tax_amount' => (int) round($taxAmount * 100),
                'discount_percentage' => $discountPercentage,
                'discount_amount' => (int) round($discountAmount * 100),
                'shipping_amount' => (int) round($shippingAmount * 100),
                'total_amount' => (int) round($totalAmount * 100),
                'paid_amount' => (int) round($paidAmount * 100),
                'due_amount' => (int) round($dueAmount * 100),
                'status' => $status,
                'payment_status' => $paymentStatus,
                'payment_method' => $paymentMethod,
                'note' => 'Seeded purchase #' . $i,
            ]);

            foreach ($lineItems as $item) {
                $product = $item['product'];
                $quantity = $item['quantity'];
                $unitPrice = $item['unit_price'];
                $subTotal = $item['sub_total'];

                PurchaseDetail::create([
                    'purchase_id' => $purchase->id,
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

                if ($status === 'Completed') {
                    $product->update([
                        'product_quantity' => $product->product_quantity + $quantity,
                    ]);
                }
            }

            if ($paidAmount > 0) {
                PurchasePayment::create([
                    'purchase_id' => $purchase->id,
                    'amount' => $paidAmount,
                    'date' => $purchaseDate,
                    'reference' => 'INV/' . $purchase->reference,
                    'payment_method' => $paymentMethod,
                    'note' => 'Seeded payment for purchase #' . $i,
                ]);
            }
        }
    }
}
