@csrf

<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="recipe_id">Recipe <span class="text-danger">*</span></label>
            <select class="form-control" name="recipe_id" id="recipe_id" required>
                <option value="">Select recipe</option>
                @foreach(($recipes ?? collect()) as $recipe)
                    <option value="{{ $recipe->id }}" {{ (string) old('recipe_id', optional($productionRun ?? null)->recipe_id) === (string) $recipe->id ? 'selected' : '' }}>
                        {{ $recipe->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="product_id">Product <span class="text-danger">*</span></label>
            <select class="form-control" name="product_id" id="product_id" required>
                <option value="">Select product</option>
                @foreach(($products ?? collect()) as $product)
                    <option value="{{ $product->id }}" {{ (string) old('product_id', optional($productionRun ?? null)->product_id) === (string) $product->id ? 'selected' : '' }}>
                        {{ $product->product_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="quantity_produced">Quantity Produced <span class="text-danger">*</span></label>
            <input type="number" step="0.001" min="0.001" class="form-control" name="quantity_produced" id="quantity_produced" value="{{ old('quantity_produced', optional($productionRun ?? null)->quantity_produced ?? 1) }}" required>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="production_date">Production Date <span class="text-danger">*</span></label>
            <input type="date" class="form-control" name="production_date" id="production_date" value="{{ old('production_date', optional(optional($productionRun ?? null)->production_date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="batch_number">Batch Number <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="batch_number" id="batch_number" value="{{ old('batch_number', optional($productionRun ?? null)->batch_number) }}" required>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select class="form-control" name="status" id="status" required>
                @foreach(['planned', 'in-progress', 'completed', 'cancelled'] as $statusOption)
                    <option value="{{ $statusOption }}" {{ old('status', optional($productionRun ?? null)->status ?? 'planned') === $statusOption ? 'selected' : '' }}>
                        {{ ucfirst($statusOption) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="produced_by">Produced By <span class="text-danger">*</span></label>
            <select class="form-control" name="produced_by" id="produced_by" required>
                <option value="">Select user</option>
                @foreach(($users ?? collect()) as $user)
                    <option value="{{ $user->id }}" {{ (string) old('produced_by', optional($productionRun ?? null)->produced_by) === (string) $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="notes">Notes</label>
    <textarea class="form-control" name="notes" id="notes" rows="4">{{ old('notes', optional($productionRun ?? null)->notes) }}</textarea>
</div>

<div class="d-flex flex-wrap justify-content-between mt-3">
    <a href="{{ route('production-runs.index') }}" class="btn btn-secondary mb-2">Cancel</a>
    <button type="submit" class="btn btn-primary mb-2">{{ $buttonText }}</button>
</div>
