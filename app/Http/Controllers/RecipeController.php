<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Models\Recipe;
use Modules\Product\Entities\Product;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipes = Recipe::query()->with('product')->latest()->paginate(15);

        return view('recipes.index', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::query()->orderBy('product_name')->get(['id', 'product_name']);

        return view('recipes.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecipeRequest $request)
    {
        Recipe::create($request->validated());

        toast('Recipe Created!', 'success');

        return redirect()->route('recipes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe)
    {
        $recipe->load('product');

        return view('recipes.show', compact('recipe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $recipe)
    {
        $products = Product::query()->orderBy('product_name')->get(['id', 'product_name']);

        return view('recipes.edit', compact('recipe', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $recipe->update($request->validated());

        toast('Recipe Updated!', 'info');

        return redirect()->route('recipes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        toast('Recipe Deleted!', 'warning');

        return redirect()->route('recipes.index');
    }
}
