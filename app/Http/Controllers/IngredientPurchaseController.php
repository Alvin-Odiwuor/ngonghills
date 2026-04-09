<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIngredientPurchaseRequest;
use App\Http\Requests\UpdateIngredientPurchaseRequest;
use App\Models\Ingredient;
use App\Models\IngredientPurchase;
use App\Models\OutletIngredientStock;
use App\Models\IngredientStockAdjustment;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Modules\People\Entities\Supplier;

class IngredientPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ingredientPurchases = IngredientPurchase::query()
            ->with(['ingredient', 'supplier', 'outlet'])
            ->orderByDesc('purchase_date')
            ->orderByDesc('id')
            ->paginate(15);

        return view('ingredient-purchases.index', compact('ingredientPurchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ingredients = Ingredient::query()->orderBy('name')->get(['id', 'name', 'unit']);
        $suppliers = Supplier::query()->orderBy('supplier_name')->get(['id', 'supplier_name']);
        $outlets = Outlet::query()->where('status', 'active')->orderBy('name')->get(['id', 'name']);

        return view('ingredient-purchases.create', compact('ingredients', 'suppliers', 'outlets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIngredientPurchaseRequest $request)
    {
        DB::transaction(function () use ($request): void {
            $data = $request->validated();
            $data['total_cost'] = (float) $data['quantity'] * (float) $data['unit_cost'];

            $ingredientPurchase = IngredientPurchase::query()->create($data);

            $this->applyPurchaseStockMovement($ingredientPurchase);
            $this->upsertPurchaseAdjustment($ingredientPurchase);
        });

        toast('Ingredient Purchase Created!', 'success');

        return redirect()->route('ingredient-purchases.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(IngredientPurchase $ingredientPurchase)
    {
        $ingredientPurchase->load(['ingredient', 'supplier', 'outlet']);

        return view('ingredient-purchases.show', compact('ingredientPurchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IngredientPurchase $ingredientPurchase)
    {
        $ingredients = Ingredient::query()->orderBy('name')->get(['id', 'name', 'unit']);
        $suppliers = Supplier::query()->orderBy('supplier_name')->get(['id', 'supplier_name']);
        $outlets = Outlet::query()->where('status', 'active')->orderBy('name')->get(['id', 'name']);

        return view('ingredient-purchases.edit', compact('ingredientPurchase', 'ingredients', 'suppliers', 'outlets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIngredientPurchaseRequest $request, IngredientPurchase $ingredientPurchase)
    {
        DB::transaction(function () use ($request, $ingredientPurchase): void {
            $previousIngredientId = (int) $ingredientPurchase->ingredient_id;
            $previousOutletId = (int) $ingredientPurchase->outlet_id;
            $previousQuantity = (float) $ingredientPurchase->quantity;

            $data = $request->validated();
            $data['total_cost'] = (float) $data['quantity'] * (float) $data['unit_cost'];

            $this->revertPurchaseStockMovement($previousIngredientId, $previousOutletId, $previousQuantity);

            $ingredientPurchase->update($data);

            $this->applyPurchaseStockMovement($ingredientPurchase);
            $this->upsertPurchaseAdjustment($ingredientPurchase);
        });

        toast('Ingredient Purchase Updated!', 'info');

        return redirect()->route('ingredient-purchases.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IngredientPurchase $ingredientPurchase)
    {
        DB::transaction(function () use ($ingredientPurchase): void {
            $this->revertPurchaseStockMovement((int) $ingredientPurchase->ingredient_id, (int) $ingredientPurchase->outlet_id, (float) $ingredientPurchase->quantity);

            IngredientStockAdjustment::query()
                ->where('reference_type', IngredientPurchase::class)
                ->where('reference_id', $ingredientPurchase->id)
                ->delete();

            $ingredientPurchase->delete();
        });

        toast('Ingredient Purchase Deleted!', 'warning');

        return redirect()->route('ingredient-purchases.index');
    }

    private function applyPurchaseStockMovement(IngredientPurchase $ingredientPurchase): void
    {
        $ingredient = Ingredient::query()
            ->whereKey($ingredientPurchase->ingredient_id)
            ->lockForUpdate()
            ->firstOrFail();

        $outletStock = $this->resolveOutletStock((int) $ingredientPurchase->outlet_id, (int) $ingredientPurchase->ingredient_id);

        $quantity = (float) $ingredientPurchase->quantity;

        $ingredient->update([
            'current_stock' => round((float) $ingredient->current_stock + $quantity, 3),
        ]);

        $outletStock->update([
            'current_stock' => round((float) $outletStock->current_stock + $quantity, 3),
        ]);
    }

    private function revertPurchaseStockMovement(int $ingredientId, int $outletId, float $quantity): void
    {
        $ingredient = Ingredient::query()
            ->whereKey($ingredientId)
            ->lockForUpdate()
            ->firstOrFail();

        $outletStock = $this->resolveOutletStock($outletId, $ingredientId);

        $newStock = round((float) $ingredient->current_stock - $quantity, 3);
        $newOutletStock = round((float) $outletStock->current_stock - $quantity, 3);

        if ($newStock < 0 || $newOutletStock < 0) {
            throw ValidationException::withMessages([
                'quantity' => 'This change would reduce ingredient stock below zero.',
            ]);
        }

        $ingredient->update([
            'current_stock' => $newStock,
        ]);

        $outletStock->update([
            'current_stock' => $newOutletStock,
        ]);
    }

    private function upsertPurchaseAdjustment(IngredientPurchase $ingredientPurchase): void
    {
        $adjustedBy = auth()->id() ?: User::query()->value('id');

        if (! $adjustedBy) {
            throw ValidationException::withMessages([
                'ingredient_id' => 'No user found for stock adjustment attribution.',
            ]);
        }

        $payload = [
            'ingredient_id' => $ingredientPurchase->ingredient_id,
            'outlet_id' => $ingredientPurchase->outlet_id,
            'adjustment_type' => 'addition',
            'quantity' => $ingredientPurchase->quantity,
            'reason' => 'purchase',
            'reference_id' => $ingredientPurchase->id,
            'reference_type' => IngredientPurchase::class,
            'notes' => 'Auto-addition from ingredient purchase invoice '.$ingredientPurchase->invoice_number.'.',
            'adjusted_by' => $adjustedBy,
        ];

        $adjustment = IngredientStockAdjustment::query()
            ->where('reference_type', IngredientPurchase::class)
            ->where('reference_id', $ingredientPurchase->id)
            ->first();

        if ($adjustment) {
            $adjustment->update($payload);

            return;
        }

        IngredientStockAdjustment::query()->create($payload);
    }

    private function resolveOutletStock(int $outletId, int $ingredientId): OutletIngredientStock
    {
        $outletStock = OutletIngredientStock::query()
            ->where('outlet_id', $outletId)
            ->where('ingredient_id', $ingredientId)
            ->lockForUpdate()
            ->first();

        if ($outletStock) {
            return $outletStock;
        }

        OutletIngredientStock::query()->create([
            'outlet_id' => $outletId,
            'ingredient_id' => $ingredientId,
            'current_stock' => 0,
        ]);

        return OutletIngredientStock::query()
            ->where('outlet_id', $outletId)
            ->where('ingredient_id', $ingredientId)
            ->lockForUpdate()
            ->firstOrFail();
    }
}
