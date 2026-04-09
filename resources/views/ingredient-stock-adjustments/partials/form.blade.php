@csrf

<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="ingredient_id">Ingredient <span class="text-danger">*</span></label>
            <select class="form-control" name="ingredient_id" id="ingredient_id" required>
                <option value="">Select ingredient</option>
                @foreach(($ingredients ?? collect()) as $ingredient)
                    <option value="{{ $ingredient->id }}" {{ (string) old('ingredient_id', optional($ingredientStockAdjustment ?? null)->ingredient_id) === (string) $ingredient->id ? 'selected' : '' }}>
                        {{ $ingredient->name }} (Stock: {{ number_format((float) $ingredient->current_stock, 3) }} {{ $ingredient->unit }})
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="adjustment_type">Adjustment Type <span class="text-danger">*</span></label>
            <select class="form-control" name="adjustment_type" id="adjustment_type" required>
                <option value="addition" {{ old('adjustment_type', optional($ingredientStockAdjustment ?? null)->adjustment_type ?? 'addition') === 'addition' ? 'selected' : '' }}>Addition</option>
                <option value="deduction" {{ old('adjustment_type', optional($ingredientStockAdjustment ?? null)->adjustment_type ?? 'addition') === 'deduction' ? 'selected' : '' }}>Deduction</option>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="quantity">Quantity <span class="text-danger">*</span></label>
            <input type="number" step="0.001" min="0.001" class="form-control" name="quantity" id="quantity" value="{{ old('quantity', optional($ingredientStockAdjustment ?? null)->quantity ?? 1) }}" required>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="reason">Reason <span class="text-danger">*</span></label>
            <select class="form-control" name="reason" id="reason" required>
                <option value="wastage" {{ old('reason', optional($ingredientStockAdjustment ?? null)->reason ?? 'correction') === 'wastage' ? 'selected' : '' }}>Wastage</option>
                <option value="spoilage" {{ old('reason', optional($ingredientStockAdjustment ?? null)->reason ?? 'correction') === 'spoilage' ? 'selected' : '' }}>Spoilage / Expiry</option>
                <option value="correction" {{ old('reason', optional($ingredientStockAdjustment ?? null)->reason ?? 'correction') === 'correction' ? 'selected' : '' }}>Stock Correction</option>
                <option value="return" {{ old('reason', optional($ingredientStockAdjustment ?? null)->reason ?? 'correction') === 'return' ? 'selected' : '' }}>Return (Supplier or Kitchen)</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="reference_type">Reference Type</label>
            <select class="form-control" name="reference_type" id="reference_type">
                <option value="">No reference</option>
                @foreach(($referenceTypes ?? []) as $typeValue => $typeLabel)
                    <option value="{{ $typeValue }}" {{ old('reference_type', optional($ingredientStockAdjustment ?? null)->reference_type) === $typeValue ? 'selected' : '' }}>
                        {{ $typeLabel }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="reference_id">Reference ID</label>
            <input type="number" min="1" class="form-control" name="reference_id" id="reference_id" value="{{ old('reference_id', optional($ingredientStockAdjustment ?? null)->reference_id) }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="adjusted_by">Adjusted By <span class="text-danger">*</span></label>
            <select class="form-control" name="adjusted_by" id="adjusted_by" required>
                <option value="">Select user</option>
                @foreach(($users ?? collect()) as $user)
                    <option value="{{ $user->id }}" {{ (string) old('adjusted_by', optional($ingredientStockAdjustment ?? null)->adjusted_by ?? auth()->id()) === (string) $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="notes">Notes <span class="text-danger">*</span></label>
    <textarea class="form-control" name="notes" id="notes" rows="4" required>{{ old('notes', optional($ingredientStockAdjustment ?? null)->notes) }}</textarea>
    <small class="form-text text-muted">Mandatory for audit: include what happened and where.</small>
</div>

<div class="d-flex flex-wrap justify-content-between mt-3">
    <a href="{{ route('ingredient-stock-adjustments.index') }}" class="btn btn-secondary mb-2">Cancel</a>
    <button type="submit" class="btn btn-primary mb-2">{{ $buttonText }}</button>
</div>
