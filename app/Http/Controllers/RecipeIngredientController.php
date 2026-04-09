<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecipeIngredientRequest;
use App\Http\Requests\UpdateRecipeIngredientRequest;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\RecipeIngredient;

class RecipeIngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipeIngredients = RecipeIngredient::query()
            ->with(['recipe', 'ingredient'])
            ->latest()
            ->paginate(15);

        return view('recipe-ingredients.index', compact('recipeIngredients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $recipes = Recipe::query()->orderBy('name')->get(['id', 'name']);
        $ingredients = Ingredient::query()->orderBy('name')->get(['id', 'name', 'unit']);

        return view('recipe-ingredients.create', compact('recipes', 'ingredients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecipeIngredientRequest $request)
    {
        RecipeIngredient::create($request->validated());

        toast('Recipe Ingredient Created!', 'success');

        return redirect()->route('recipe-ingredients.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(RecipeIngredient $recipeIngredient)
    {
        $recipeIngredient->load(['recipe', 'ingredient']);

        return view('recipe-ingredients.show', compact('recipeIngredient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecipeIngredient $recipeIngredient)
    {
        $recipes = Recipe::query()->orderBy('name')->get(['id', 'name']);
        $ingredients = Ingredient::query()->orderBy('name')->get(['id', 'name', 'unit']);

        return view('recipe-ingredients.edit', compact('recipeIngredient', 'recipes', 'ingredients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecipeIngredientRequest $request, RecipeIngredient $recipeIngredient)
    {
        $recipeIngredient->update($request->validated());

        toast('Recipe Ingredient Updated!', 'info');

        return redirect()->route('recipe-ingredients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecipeIngredient $recipeIngredient)
    {
        $recipeIngredient->delete();

        toast('Recipe Ingredient Deleted!', 'warning');

        return redirect()->route('recipe-ingredients.index');
    }
}
