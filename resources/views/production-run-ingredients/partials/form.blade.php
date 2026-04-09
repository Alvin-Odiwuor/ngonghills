@csrf

<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="production_run_id">Production Run <span class="text-danger">*</span></label>
            <select class="form-control" name="production_run_id" id="production_run_id" required>
                <option value="">Select production run</option>
                @foreach(($productionRuns ?? collect()) as $run)
                    <option value="{{ $run->id }}" {{ (string) old('production_run_id', optional($productionRunIngredient ?? null)->production_run_id) === (string) $run->id ? 'selected' : '' }}>
                        {{ $run->batch_number }}
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
                    <option value="{{ $ingredient->id }}" data-cost="{{ $ingredient->cost_per_unit }}" {{ (string) old('ingredient_id', optional($productionRunIngredient ?? null)->ingredient_id) === (string) $ingredient->id ? 'selected' : '' }}>
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
            <label for="quantity_used">Quantity Used <span class="text-danger">*</span></label>
            <input type="number" step="0.001" min="0.001" class="form-control" name="quantity_used" id="quantity_used" value="{{ old('quantity_used', optional($productionRunIngredient ?? null)->quantity_used ?? 1) }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="unit_cost_at_time">Unit Cost At Time <span class="text-danger">*</span></label>
            <input type="number" step="0.0001" min="0" class="form-control" name="unit_cost_at_time" id="unit_cost_at_time" value="{{ old('unit_cost_at_time', optional($productionRunIngredient ?? null)->unit_cost_at_time ?? 0) }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="total_cost">Total Cost</label>
            <input type="number" step="0.0001" min="0" class="form-control" name="total_cost" id="total_cost" value="{{ old('total_cost', optional($productionRunIngredient ?? null)->total_cost ?? 0) }}" readonly>
            <small class="form-text text-muted">Auto-calculated from quantity used × unit cost.</small>
        </div>
    </div>
</div>

<div class="d-flex flex-wrap justify-content-between mt-3">
    <a href="{{ route('production-run-ingredients.index') }}" class="btn btn-secondary mb-2">Cancel</a>
    <button type="submit" class="btn btn-primary mb-2">{{ $buttonText }}</button>
</div>

@push('page_scripts')
<script>
    (function () {
        const ingredientSelect = document.getElementById('ingredient_id');
        const quantityInput = document.getElementById('quantity_used');
        const unitCostInput = document.getElementById('unit_cost_at_time');
        const totalCostInput = document.getElementById('total_cost');

        const calculateTotal = function () {
            const quantity = parseFloat(quantityInput.value || 0);
            const unitCost = parseFloat(unitCostInput.value || 0);
            totalCostInput.value = (quantity * unitCost).toFixed(4);
        };

        ingredientSelect.addEventListener('change', function () {
            const option = ingredientSelect.options[ingredientSelect.selectedIndex];
            const cost = option ? option.getAttribute('data-cost') : null;
            if (cost !== null && cost !== '') {
                unitCostInput.value = parseFloat(cost).toFixed(4);
                calculateTotal();
            }
        });

        quantityInput.addEventListener('input', calculateTotal);
        unitCostInput.addEventListener('input', calculateTotal);
        calculateTotal();
    })();
</script>
@endpush
