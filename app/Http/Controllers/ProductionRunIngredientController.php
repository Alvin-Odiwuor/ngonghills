<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductionRunIngredientRequest;
use App\Http\Requests\UpdateProductionRunIngredientRequest;
use App\Models\Ingredient;
use App\Models\ProductionRun;
use App\Models\ProductionRunIngredient;

class ProductionRunIngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productionRunIngredients = ProductionRunIngredient::query()
            ->with(['productionRun', 'ingredient'])
            ->latest()
            ->paginate(15);

        return view('production-run-ingredients.index', compact('productionRunIngredients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productionRuns = ProductionRun::query()->orderByDesc('production_date')->get(['id', 'batch_number']);
        $ingredients = Ingredient::query()->orderBy('name')->get(['id', 'name', 'unit', 'cost_per_unit']);

        return view('production-run-ingredients.create', compact('productionRuns', 'ingredients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductionRunIngredientRequest $request)
    {
        $data = $request->validated();
        $data['total_cost'] = (float) $data['quantity_used'] * (float) $data['unit_cost_at_time'];

        ProductionRunIngredient::create($data);

        toast('Production Run Ingredient Logged!', 'success');

        return redirect()->route('production-run-ingredients.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductionRunIngredient $productionRunIngredient)
    {
        $productionRunIngredient->load(['productionRun', 'ingredient']);

        return view('production-run-ingredients.show', compact('productionRunIngredient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductionRunIngredient $productionRunIngredient)
    {
        $productionRuns = ProductionRun::query()->orderByDesc('production_date')->get(['id', 'batch_number']);
        $ingredients = Ingredient::query()->orderBy('name')->get(['id', 'name', 'unit', 'cost_per_unit']);

        return view('production-run-ingredients.edit', compact('productionRunIngredient', 'productionRuns', 'ingredients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductionRunIngredientRequest $request, ProductionRunIngredient $productionRunIngredient)
    {
        $data = $request->validated();
        $data['total_cost'] = (float) $data['quantity_used'] * (float) $data['unit_cost_at_time'];

        $productionRunIngredient->update($data);

        toast('Production Run Ingredient Updated!', 'info');

        return redirect()->route('production-run-ingredients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductionRunIngredient $productionRunIngredient)
    {
        $productionRunIngredient->delete();

        toast('Production Run Ingredient Deleted!', 'warning');

        return redirect()->route('production-run-ingredients.index');
    }
}
