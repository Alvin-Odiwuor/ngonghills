@csrf

<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="outlet_id">Outlet <span class="text-danger">*</span></label>
            <select class="form-control" name="outlet_id" id="outlet_id" required>
                <option value="">Select outlet</option>
                @foreach(($outlets ?? collect()) as $outlet)
                    <option value="{{ $outlet->id }}" {{ (string) old('outlet_id', optional($outletProduct ?? null)->outlet_id) === (string) $outlet->id ? 'selected' : '' }}>
                        {{ $outlet->name }}
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
                    <option value="{{ $product->id }}" data-base-price="{{ number_format((float) $product->product_price, 4, '.', '') }}" {{ (string) old('product_id', optional($outletProduct ?? null)->product_id) === (string) $product->id ? 'selected' : '' }}>
                        {{ $product->product_name }} (Base: {{ number_format((float) $product->product_price, 4) }})
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="price">Outlet Price <span class="text-danger">*</span></label>
            <input type="number" step="0.0001" min="0" class="form-control" name="price" id="price" value="{{ old('price', optional($outletProduct ?? null)->price) }}" required>
            <small class="form-text text-muted">Defaults to selected product base price if empty.</small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select class="form-control" name="status" id="status" required>
                <option value="active" {{ old('status', optional($outletProduct ?? null)->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', optional($outletProduct ?? null)->status ?? 'active') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
</div>

<div class="d-flex flex-wrap justify-content-between mt-3">
    <a href="{{ route('outlet-products.index') }}" class="btn btn-secondary mb-2">Cancel</a>
    <button type="submit" class="btn btn-primary mb-2">{{ $buttonText }}</button>
</div>

@push('page_scripts')
<script>
    (function () {
        const productSelect = document.getElementById('product_id');
        const priceInput = document.getElementById('price');

        if (!productSelect || !priceInput) {
            return;
        }

        const applyBasePrice = function () {
            if ((priceInput.value || '').trim() !== '') {
                return;
            }

            const selected = productSelect.options[productSelect.selectedIndex];
            const basePrice = selected ? selected.getAttribute('data-base-price') : null;

            if (basePrice) {
                priceInput.value = basePrice;
            }
        };

        productSelect.addEventListener('change', applyBasePrice);
        applyBasePrice();
    })();
</script>
@endpush
