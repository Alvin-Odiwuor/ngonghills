<?php

namespace Modules\Sale\Http\Controllers;

use App\Models\LoyaltyAccount;
use App\Models\Outlet;
use App\Models\PointTransaction;
use App\Models\Reward;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Sale\Entities\Sale;
use Modules\Sale\Entities\SaleDetails;
use Modules\Sale\Entities\SalePayment;
use Modules\Sale\Http\Requests\StorePosSaleRequest;

class PosController extends Controller
{

    public function index() {
        Cart::instance('sale')->destroy();

        $customers = Customer::all();
        $outlets = Outlet::query()->where('status', 'active')->orderBy('name')->get(['id', 'name']);
        $product_categories = Category::all();

        return view('sale::pos.index', compact('product_categories', 'customers', 'outlets'));
    }


    public function store(StorePosSaleRequest $request) {
        DB::transaction(function () use ($request) {
            $due_amount = $request->total_amount - $request->paid_amount;

            if ($due_amount == $request->total_amount) {
                $payment_status = 'Unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'Partial';
            } else {
                $payment_status = 'Paid';
            }

            $sale = Sale::create([
                'date' => now()->format('Y-m-d'),
                'reference' => 'PSL',
                'customer_id' => $request->customer_id,
                'outlet_id' => $request->outlet_id,
                'customer_name' => Customer::findOrFail($request->customer_id)->customer_name,
                'tax_percentage' => $request->tax_percentage,
                'discount_percentage' => $request->discount_percentage,
                'shipping_amount' => $request->shipping_amount * 100,
                'paid_amount' => $request->paid_amount * 100,
                'total_amount' => $request->total_amount * 100,
                'due_amount' => $due_amount * 100,
                'status' => 'Completed',
                'payment_status' => $payment_status,
                'payment_method' => $request->payment_method,
                'note' => $request->note,
                'tax_amount' => Cart::instance('sale')->tax() * 100,
                'discount_amount' => Cart::instance('sale')->discount() * 100,
            ]);

            $loyaltyAccount = LoyaltyAccount::firstOrCreate(
                ['customer_id' => $request->customer_id],
                [
                    'points_balance' => 0,
                    'total_points_earned' => 0,
                    'total_points_redeemed' => 0,
                    'tier' => 'Bronze',
                    'status' => 'active',
                ]
            );

            $earnedPointsFromSale = 0;

            foreach (Cart::instance('sale')->content() as $cart_item) {
                SaleDetails::create([
                    'sale_id' => $sale->id,
                    'product_id' => $cart_item->id,
                    'product_name' => $cart_item->name,
                    'product_code' => $cart_item->options->code,
                    'quantity' => $cart_item->qty,
                    'price' => $cart_item->price * 100,
                    'unit_price' => $cart_item->options->unit_price * 100,
                    'sub_total' => $cart_item->options->sub_total * 100,
                    'product_discount_amount' => $cart_item->options->product_discount * 100,
                    'product_discount_type' => $cart_item->options->product_discount_type,
                    'product_tax_amount' => $cart_item->options->product_tax * 100,
                ]);

                $reward = Reward::query()
                    ->where('product_id', $cart_item->id)
                    ->where('is_active', true)
                    ->where(function ($query) {
                        $query->whereNull('expires_at')->orWhereDate('expires_at', '>=', now()->toDateString());
                    })
                    ->latest('id')
                    ->first();

                if ($reward) {
                    $pointsPerUnit = is_numeric($reward->reward_value)
                        ? (int) $reward->reward_value
                        : (int) $reward->points_required;

                    $linePoints = max(0, $pointsPerUnit) * (int) $cart_item->qty;

                    if ($linePoints > 0) {
                        PointTransaction::create([
                            'loyalty_account_id' => $loyaltyAccount->id,
                            'sale_id' => $sale->id,
                            'type' => 'earn',
                            'points' => $linePoints,
                            'description' => 'Points earned from POS sale item: ' . $cart_item->name,
                        ]);

                        $earnedPointsFromSale += $linePoints;
                    }
                }

                $product = Product::findOrFail($cart_item->id);
                $product->update([
                    'product_quantity' => $product->product_quantity - $cart_item->qty
                ]);
            }

            if ($earnedPointsFromSale > 0) {
                $loyaltyAccount->increment('points_balance', $earnedPointsFromSale);
                $loyaltyAccount->increment('total_points_earned', $earnedPointsFromSale);
            }

            Cart::instance('sale')->destroy();

            if ($sale->paid_amount > 0) {
                SalePayment::create([
                    'date' => now()->format('Y-m-d'),
                    'reference' => 'INV/'.$sale->reference,
                    'amount' => $sale->paid_amount,
                    'sale_id' => $sale->id,
                    'payment_method' => $request->payment_method
                ]);
            }
        });

        toast('POS Sale Created!', 'success');

        return redirect()->route('sales.index');
    }
}
