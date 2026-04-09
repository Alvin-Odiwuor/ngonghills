@csrf

<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="ingredient_id">Ingredient <span class="text-danger">*</span></label>
            <select class="form-control" name="ingredient_id" id="ingredient_id" required>
                <option value="">Select ingredient</option>
                @foreach(($ingredients ?? collect()) as $ingredient)
                    <option value="{{ $ingredient->id }}" {{ (string) old('ingredient_id', optional($ingredientPurchase ?? null)->ingredient_id) === (string) $ingredient->id ? 'selected' : '' }}>
                        {{ $ingredient->name }} ({{ $ingredient->unit }})
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="supplier_id">Supplier <span class="text-danger">*</span></label>
            <select class="form-control" name="supplier_id" id="supplier_id" required>
                <option value="">Select supplier</option>
                @foreach(($suppliers ?? collect()) as $supplier)
                    <option value="{{ $supplier->id }}" {{ (string) old('supplier_id', optional($ingredientPurchase ?? null)->supplier_id) === (string) $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->supplier_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="outlet_id">Outlet <span class="text-danger">*</span></label>
            <select class="form-control" name="outlet_id" id="outlet_id" required>
                <option value="">Select outlet</option>
                @foreach(($outlets ?? collect()) as $outlet)
                    <option value="{{ $outlet->id }}" {{ (string) old('outlet_id', optional($ingredientPurchase ?? null)->outlet_id) === (string) $outlet->id ? 'selected' : '' }}>
                        {{ $outlet->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="quantity">Quantity <span class="text-danger">*</span></label>
            <input type="number" step="0.001" min="0.001" class="form-control" name="quantity" id="quantity" value="{{ old('quantity', optional($ingredientPurchase ?? null)->quantity ?? 1) }}" required>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="unit_cost">Unit Cost <span class="text-danger">*</span></label>
            <input type="number" step="0.0001" min="0" class="form-control" name="unit_cost" id="unit_cost" value="{{ old('unit_cost', optional($ingredientPurchase ?? null)->unit_cost ?? 0) }}" required>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="total_cost">Total Cost</label>
            <input type="number" step="0.0001" min="0" class="form-control" name="total_cost" id="total_cost" value="{{ old('total_cost', optional($ingredientPurchase ?? null)->total_cost ?? 0) }}" readonly>
            <small class="form-text text-muted">Auto-calculated from quantity × unit cost.</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="purchase_date">Purchase Date <span class="text-danger">*</span></label>
            <input type="date" class="form-control" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', optional(optional($ingredientPurchase ?? null)->purchase_date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="invoice_number">Invoice Number <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="invoice_number" id="invoice_number" value="{{ old('invoice_number', optional($ingredientPurchase ?? null)->invoice_number) }}" required>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="notes">Notes</label>
    <textarea class="form-control" name="notes" id="notes" rows="4">{{ old('notes', optional($ingredientPurchase ?? null)->notes) }}</textarea>
</div>

<div class="d-flex flex-wrap justify-content-between mt-3">
    <a href="{{ route('ingredient-purchases.index') }}" class="btn btn-secondary mb-2">Cancel</a>
    <button type="submit" class="btn btn-primary mb-2">{{ $buttonText }}</button>
</div>

@push('page_scripts')
<script>
    (function () {
        const quantityInput = document.getElementById('quantity');
        const unitCostInput = document.getElementById('unit_cost');
        const totalCostInput = document.getElementById('total_cost');

        const calculateTotal = function () {
            const quantity = parseFloat(quantityInput.value || 0);
            const unitCost = parseFloat(unitCostInput.value || 0);
            totalCostInput.value = (quantity * unitCost).toFixed(4);
        };

        quantityInput.addEventListener('input', calculateTotal);
        unitCostInput.addEventListener('input', calculateTotal);
        calculateTotal();
    })();
</script>
@endpush
