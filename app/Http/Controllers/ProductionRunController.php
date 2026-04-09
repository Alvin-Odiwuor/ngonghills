<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductionRunRequest;
use App\Http\Requests\UpdateProductionRunRequest;
use App\Models\Ingredient;
use App\Models\IngredientStockAdjustment;
use App\Models\Outlet;
use App\Models\ProductionRun;
use App\Models\ProductionRunIngredient;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Modules\Product\Entities\Product;

class ProductionRunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productionRuns = ProductionRun::query()
            ->with(['recipe', 'product', 'outlet', 'user'])
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
        $outlets = Outlet::query()->where('status', 'active')->orderBy('name')->get(['id', 'name']);
        $users = User::query()->orderBy('name')->get(['id', 'name']);

        return view('production-runs.create', compact('recipes', 'products', 'outlets', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductionRunRequest $request)
    {
        DB::transaction(function () use ($request): void {
            $productionRun = ProductionRun::create($request->validated());

            if ($productionRun->status === 'completed') {
                $this->postStockMovementsForCompletion($productionRun);
            }
        });

        toast('Production Run Created!', 'success');

        return redirect()->route('production-runs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductionRun $productionRun)
    {
        $productionRun->load(['recipe', 'product', 'outlet', 'user']);

        return view('production-runs.show', compact('productionRun'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductionRun $productionRun)
    {
        $recipes = Recipe::query()->orderBy('name')->get(['id', 'name']);
        $products = Product::query()->orderBy('product_name')->get(['id', 'product_name']);
        $outlets = Outlet::query()->where('status', 'active')->orderBy('name')->get(['id', 'name']);
        $users = User::query()->orderBy('name')->get(['id', 'name']);

        return view('production-runs.edit', compact('productionRun', 'recipes', 'products', 'outlets', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductionRunRequest $request, ProductionRun $productionRun)
    {
        DB::transaction(function () use ($request, $productionRun): void {
            $previousStatus = $productionRun->status;

            $productionRun->update($request->validated());

            if ($previousStatus !== 'completed' && $productionRun->status === 'completed') {
                $this->postStockMovementsForCompletion($productionRun);
            }
        });

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

    protected function postStockMovementsForCompletion(ProductionRun $productionRun): void
    {
        $productionRun->loadMissing('recipe');

        if (ProductionRunIngredient::query()->where('production_run_id', $productionRun->id)->exists()) {
            throw ValidationException::withMessages([
                'status' => 'Stock movements have already been posted for this production run.',
            ]);
        }

        $recipeIngredients = RecipeIngredient::query()
            ->with('ingredient')
            ->where('recipe_id', $productionRun->recipe_id)
            ->get();

        if ($recipeIngredients->isEmpty()) {
            throw ValidationException::withMessages([
                'recipe_id' => 'The selected recipe has no ingredients to consume.',
            ]);
        }

        foreach ($recipeIngredients as $recipeIngredient) {
            $ingredient = Ingredient::query()
                ->whereKey($recipeIngredient->ingredient_id)
                ->lockForUpdate()
                ->first();

            if (! $ingredient instanceof Ingredient) {
                throw ValidationException::withMessages([
                    'recipe_id' => 'One or more recipe ingredients are invalid.',
                ]);
            }

            $quantityUsed = round((float) $recipeIngredient->quantity_required * (float) $productionRun->quantity_produced, 3);

            if ($quantityUsed <= 0) {
                continue;
            }

            $newStock = round((float) $ingredient->current_stock - $quantityUsed, 3);

            if ($newStock < 0) {
                throw ValidationException::withMessages([
                    'status' => "Insufficient stock for ingredient {$ingredient->name}.",
                ]);
            }

            $ingredient->update(['current_stock' => $newStock]);

            $unitCost = (float) $ingredient->cost_per_unit;
            $totalCost = round($unitCost * $quantityUsed, 4);

            ProductionRunIngredient::query()->create([
                'production_run_id' => $productionRun->id,
                'ingredient_id' => $ingredient->id,
                'quantity_used' => $quantityUsed,
                'unit_cost_at_time' => $unitCost,
                'total_cost' => $totalCost,
            ]);

            IngredientStockAdjustment::query()->create([
                'ingredient_id' => $ingredient->id,
                'adjustment_type' => 'deduction',
                'quantity' => $quantityUsed,
                'reason' => 'correction',
                'reference_id' => $productionRun->id,
                'reference_type' => ProductionRun::class,
                'notes' => "Auto-deduction for completed production run #{$productionRun->id}.",
                'adjusted_by' => $productionRun->produced_by,
            ]);
        }
    }
}
