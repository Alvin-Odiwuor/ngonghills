<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIngredientStockAdjustmentRequest;
use App\Http\Requests\UpdateIngredientStockAdjustmentRequest;
use App\Models\Ingredient;
use App\Models\IngredientPurchase;
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
            ->with(['ingredient', 'user', 'reference'])
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
        $users = User::query()->orderBy('name')->get(['id', 'name']);
        $referenceTypes = [
            IngredientPurchase::class => 'Ingredient Purchase',
            ProductionRun::class => 'Production Run',
        ];

        return view('ingredient-stock-adjustments.create', compact('ingredients', 'users', 'referenceTypes'));
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
            $signedQuantity = $this->signedQuantity($data['adjustment_type'], (float) $data['quantity']);

            $this->applyStockChange($ingredient, $signedQuantity);

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
        $ingredientStockAdjustment->load(['ingredient', 'user', 'reference']);

        return view('ingredient-stock-adjustments.show', compact('ingredientStockAdjustment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IngredientStockAdjustment $ingredientStockAdjustment)
    {
        $ingredients = Ingredient::query()->orderBy('name')->get(['id', 'name', 'unit', 'current_stock']);
        $users = User::query()->orderBy('name')->get(['id', 'name']);
        $referenceTypes = [
            IngredientPurchase::class => 'Ingredient Purchase',
            ProductionRun::class => 'Production Run',
        ];

        return view('ingredient-stock-adjustments.edit', compact('ingredientStockAdjustment', 'ingredients', 'users', 'referenceTypes'));
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
            $reverseQuantity = -1 * $this->signedQuantity($ingredientStockAdjustment->adjustment_type, (float) $ingredientStockAdjustment->quantity);
            $this->applyStockChange($oldIngredient, $reverseQuantity);

            $newIngredient = (int) $data['ingredient_id'] === (int) $ingredientStockAdjustment->ingredient_id
                ? $oldIngredient
                : Ingredient::query()->whereKey($data['ingredient_id'])->lockForUpdate()->firstOrFail();

            $newSignedQuantity = $this->signedQuantity($data['adjustment_type'], (float) $data['quantity']);
            $this->applyStockChange($newIngredient, $newSignedQuantity);

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
            $reverseQuantity = -1 * $this->signedQuantity($ingredientStockAdjustment->adjustment_type, (float) $ingredientStockAdjustment->quantity);
            $this->applyStockChange($ingredient, $reverseQuantity);

            $ingredientStockAdjustment->delete();
        });

        toast('Ingredient Stock Adjustment Deleted!', 'warning');

        return redirect()->route('ingredient-stock-adjustments.index');
    }

    private function signedQuantity(string $adjustmentType, float $quantity): float
    {
        return $adjustmentType === 'deduction' ? -1 * $quantity : $quantity;
    }

    private function applyStockChange(Ingredient $ingredient, float $signedQuantity): void
    {
        $newStock = (float) $ingredient->current_stock + $signedQuantity;

        if ($newStock < 0) {
            throw ValidationException::withMessages([
                'quantity' => 'This adjustment would reduce stock below zero for the selected ingredient.',
            ]);
        }

        $ingredient->update([
            'current_stock' => $newStock,
        ]);
    }
}
