<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIngredientStockAdjustmentRequest;
use App\Http\Requests\UpdateIngredientStockAdjustmentRequest;
use App\Models\Ingredient;
use App\Models\IngredientPurchase;
use App\Models\Outlet;
use App\Models\OutletIngredientStock;
use App\Models\IngredientStockAdjustment;
use App\Models\ProductionRun;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class IngredientStockAdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ingredientStockAdjustments = IngredientStockAdjustment::query()
            ->with(['ingredient', 'outlet', 'user', 'reference'])
            ->latest()
            ->paginate(15);

        return view('ingredient-stock-adjustments.index', compact('ingredientStockAdjustments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ingredients = Ingredient::query()->orderBy('name')->get(['id', 'name', 'unit', 'current_stock']);
        $outlets = Outlet::query()->where('status', 'active')->orderBy('name')->get(['id', 'name']);
        $users = User::query()->orderBy('name')->get(['id', 'name']);
        $referenceTypes = [
            IngredientPurchase::class => 'Ingredient Purchase',
            ProductionRun::class => 'Production Run',
        ];

        return view('ingredient-stock-adjustments.create', compact('ingredients', 'outlets', 'users', 'referenceTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIngredientStockAdjustmentRequest $request)
    {
        DB::transaction(function () use ($request) {
            $data = $request->validated();
            $data['reference_type'] = $data['reference_type'] ?? null;
            $data['reference_id'] = $data['reference_id'] ?? null;

            $ingredient = Ingredient::query()->whereKey($data['ingredient_id'])->lockForUpdate()->firstOrFail();
            $outletStock = $this->resolveOutletStock((int) $data['outlet_id'], (int) $data['ingredient_id']);
            $signedQuantity = $this->signedQuantity($data['adjustment_type'], (float) $data['quantity']);

            $this->applyStockChange($ingredient, $outletStock, $signedQuantity);

            IngredientStockAdjustment::create($data);
        });

        toast('Ingredient Stock Adjustment Created!', 'success');

        return redirect()->route('ingredient-stock-adjustments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(IngredientStockAdjustment $ingredientStockAdjustment)
    {
        $ingredientStockAdjustment->load(['ingredient', 'outlet', 'user', 'reference']);

        return view('ingredient-stock-adjustments.show', compact('ingredientStockAdjustment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IngredientStockAdjustment $ingredientStockAdjustment)
    {
        $ingredients = Ingredient::query()->orderBy('name')->get(['id', 'name', 'unit', 'current_stock']);
        $outlets = Outlet::query()->where('status', 'active')->orderBy('name')->get(['id', 'name']);
        $users = User::query()->orderBy('name')->get(['id', 'name']);
        $referenceTypes = [
            IngredientPurchase::class => 'Ingredient Purchase',
            ProductionRun::class => 'Production Run',
        ];

        return view('ingredient-stock-adjustments.edit', compact('ingredientStockAdjustment', 'ingredients', 'outlets', 'users', 'referenceTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIngredientStockAdjustmentRequest $request, IngredientStockAdjustment $ingredientStockAdjustment)
    {
        DB::transaction(function () use ($request, $ingredientStockAdjustment) {
            $data = $request->validated();
            $data['reference_type'] = $data['reference_type'] ?? null;
            $data['reference_id'] = $data['reference_id'] ?? null;

            $oldIngredient = Ingredient::query()->whereKey($ingredientStockAdjustment->ingredient_id)->lockForUpdate()->firstOrFail();
            $oldOutletStock = $this->resolveOutletStock((int) $ingredientStockAdjustment->outlet_id, (int) $ingredientStockAdjustment->ingredient_id);
            $reverseQuantity = -1 * $this->signedQuantity($ingredientStockAdjustment->adjustment_type, (float) $ingredientStockAdjustment->quantity);
            $this->applyStockChange($oldIngredient, $oldOutletStock, $reverseQuantity);

            $newIngredient = (int) $data['ingredient_id'] === (int) $ingredientStockAdjustment->ingredient_id
                ? $oldIngredient
                : Ingredient::query()->whereKey($data['ingredient_id'])->lockForUpdate()->firstOrFail();

            $newOutletStock = (int) $data['ingredient_id'] === (int) $ingredientStockAdjustment->ingredient_id
                && (int) $data['outlet_id'] === (int) $ingredientStockAdjustment->outlet_id
                ? $oldOutletStock
                : $this->resolveOutletStock((int) $data['outlet_id'], (int) $data['ingredient_id']);

            $newSignedQuantity = $this->signedQuantity($data['adjustment_type'], (float) $data['quantity']);
            $this->applyStockChange($newIngredient, $newOutletStock, $newSignedQuantity);

            $ingredientStockAdjustment->update($data);
        });

        toast('Ingredient Stock Adjustment Updated!', 'info');

        return redirect()->route('ingredient-stock-adjustments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IngredientStockAdjustment $ingredientStockAdjustment)
    {
        DB::transaction(function () use ($ingredientStockAdjustment) {
            $ingredient = Ingredient::query()->whereKey($ingredientStockAdjustment->ingredient_id)->lockForUpdate()->firstOrFail();
            $outletStock = $this->resolveOutletStock((int) $ingredientStockAdjustment->outlet_id, (int) $ingredientStockAdjustment->ingredient_id);
            $reverseQuantity = -1 * $this->signedQuantity($ingredientStockAdjustment->adjustment_type, (float) $ingredientStockAdjustment->quantity);
            $this->applyStockChange($ingredient, $outletStock, $reverseQuantity);

            $ingredientStockAdjustment->delete();
        });

        toast('Ingredient Stock Adjustment Deleted!', 'warning');

        return redirect()->route('ingredient-stock-adjustments.index');
    }

    private function signedQuantity(string $adjustmentType, float $quantity): float
    {
        return $adjustmentType === 'deduction' ? -1 * $quantity : $quantity;
    }

    private function applyStockChange(Ingredient $ingredient, OutletIngredientStock $outletStock, float $signedQuantity): void
    {
        $newStock = (float) $ingredient->current_stock + $signedQuantity;
        $newOutletStock = (float) $outletStock->current_stock + $signedQuantity;

        if ($newStock < 0 || $newOutletStock < 0) {
            throw ValidationException::withMessages([
                'quantity' => 'This adjustment would reduce stock below zero for the selected ingredient.',
            ]);
        }

        $ingredient->update([
            'current_stock' => $newStock,
        ]);

        $outletStock->update([
            'current_stock' => $newOutletStock,
        ]);
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
