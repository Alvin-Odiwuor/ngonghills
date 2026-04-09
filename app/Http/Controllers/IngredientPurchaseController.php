<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIngredientPurchaseRequest;
use App\Http\Requests\UpdateIngredientPurchaseRequest;
use App\Models\Ingredient;
use App\Models\IngredientPurchase;
use Modules\People\Entities\Supplier;

class IngredientPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ingredientPurchases = IngredientPurchase::query()
            ->with(['ingredient', 'supplier'])
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

        return view('ingredient-purchases.create', compact('ingredients', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIngredientPurchaseRequest $request)
    {
        $data = $request->validated();
        $data['total_cost'] = (float) $data['quantity'] * (float) $data['unit_cost'];

        IngredientPurchase::create($data);

        toast('Ingredient Purchase Created!', 'success');

        return redirect()->route('ingredient-purchases.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(IngredientPurchase $ingredientPurchase)
    {
        $ingredientPurchase->load(['ingredient', 'supplier']);

        return view('ingredient-purchases.show', compact('ingredientPurchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IngredientPurchase $ingredientPurchase)
    {
        $ingredients = Ingredient::query()->orderBy('name')->get(['id', 'name', 'unit']);
        $suppliers = Supplier::query()->orderBy('supplier_name')->get(['id', 'supplier_name']);

        return view('ingredient-purchases.edit', compact('ingredientPurchase', 'ingredients', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIngredientPurchaseRequest $request, IngredientPurchase $ingredientPurchase)
    {
        $data = $request->validated();
        $data['total_cost'] = (float) $data['quantity'] * (float) $data['unit_cost'];

        $ingredientPurchase->update($data);

        toast('Ingredient Purchase Updated!', 'info');

        return redirect()->route('ingredient-purchases.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IngredientPurchase $ingredientPurchase)
    {
        $ingredientPurchase->delete();

        toast('Ingredient Purchase Deleted!', 'warning');

        return redirect()->route('ingredient-purchases.index');
    }
}
