@csrf

<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="recipe_id">Recipe <span class="text-danger">*</span></label>
            <select class="form-control" name="recipe_id" id="recipe_id" required>
                <option value="">Select recipe</option>
                @foreach(($recipes ?? collect()) as $recipe)
                    <option value="{{ $recipe->id }}" {{ (string) old('recipe_id', optional($recipeIngredient ?? null)->recipe_id) === (string) $recipe->id ? 'selected' : '' }}>
                        {{ $recipe->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="ingredient_id">Ingredient <span class="text-danger">*</span></label>
            <select class="form-control" name="ingredient_id" id="ingredient_id" required>
                <option value="">Select ingredient</option>
                @foreach(($ingredients ?? collect()) as $ingredient)
                    <option value="{{ $ingredient->id }}" {{ (string) old('ingredient_id', optional($recipeIngredient ?? null)->ingredient_id) === (string) $ingredient->id ? 'selected' : '' }}>
                        {{ $ingredient->name }} ({{ $ingredient->unit }})
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="quantity_required">Quantity Required <span class="text-danger">*</span></label>
            <input type="number" step="0.001" min="0.001" class="form-control" name="quantity_required" id="quantity_required" value="{{ old('quantity_required', optional($recipeIngredient ?? null)->quantity_required ?? 1) }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="unit">Unit <span class="text-danger">*</span></label>
            <select class="form-control" name="unit" id="unit" required>
                @foreach(['g', 'ml', 'kg', 'L', 'pcs'] as $unit)
                    <option value="{{ $unit }}" {{ old('unit', optional($recipeIngredient ?? null)->unit ?? 'pcs') === $unit ? 'selected' : '' }}>{{ $unit }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="notes">Notes</label>
    <textarea class="form-control" name="notes" id="notes" rows="4">{{ old('notes', optional($recipeIngredient ?? null)->notes) }}</textarea>
</div>

<div class="d-flex flex-wrap justify-content-between mt-3">
    <a href="{{ route('recipe-ingredients.index') }}" class="btn btn-secondary mb-2">Cancel</a>
    <button type="submit" class="btn btn-primary mb-2">{{ $buttonText }}</button>
</div>
