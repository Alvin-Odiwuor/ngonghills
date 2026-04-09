<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductionRunRequest;
use App\Http\Requests\UpdateProductionRunRequest;
use App\Models\ProductionRun;
use App\Models\Recipe;
use App\Models\User;
use Modules\Product\Entities\Product;

class ProductionRunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productionRuns = ProductionRun::query()
            ->with(['recipe', 'product', 'user'])
            ->orderByDesc('production_date')
            ->orderByDesc('id')
            ->paginate(15);

        return view('production-runs.index', compact('productionRuns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $recipes = Recipe::query()->orderBy('name')->get(['id', 'name']);
        $products = Product::query()->orderBy('product_name')->get(['id', 'product_name']);
        $users = User::query()->orderBy('name')->get(['id', 'name']);

        return view('production-runs.create', compact('recipes', 'products', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductionRunRequest $request)
    {
        ProductionRun::create($request->validated());

        toast('Production Run Created!', 'success');

        return redirect()->route('production-runs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductionRun $productionRun)
    {
        $productionRun->load(['recipe', 'product', 'user']);

        return view('production-runs.show', compact('productionRun'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductionRun $productionRun)
    {
        $recipes = Recipe::query()->orderBy('name')->get(['id', 'name']);
        $products = Product::query()->orderBy('product_name')->get(['id', 'product_name']);
        $users = User::query()->orderBy('name')->get(['id', 'name']);

        return view('production-runs.edit', compact('productionRun', 'recipes', 'products', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductionRunRequest $request, ProductionRun $productionRun)
    {
        $productionRun->update($request->validated());

        toast('Production Run Updated!', 'info');

        return redirect()->route('production-runs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductionRun $productionRun)
    {
        $productionRun->delete();

        toast('Production Run Deleted!', 'warning');

        return redirect()->route('production-runs.index');
    }
}
