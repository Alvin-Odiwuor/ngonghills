@csrf

<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', optional($recipe ?? null)->name) }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="product_id">Product <span class="text-danger">*</span></label>
            <select class="form-control" name="product_id" id="product_id" required>
                <option value="">Select product</option>
                @foreach(($products ?? collect()) as $product)
                    <option value="{{ $product->id }}" {{ (string) old('product_id', optional($recipe ?? null)->product_id) === (string) $product->id ? 'selected' : '' }}>
                        {{ $product->product_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select class="form-control" name="status" id="status" required>
                <option value="active" {{ old('status', optional($recipe ?? null)->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', optional($recipe ?? null)->status ?? 'active') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="yield_quantity">Yield Quantity <span class="text-danger">*</span></label>
            <input type="number" step="0.001" min="0.001" class="form-control" name="yield_quantity" id="yield_quantity" value="{{ old('yield_quantity', optional($recipe ?? null)->yield_quantity ?? 1) }}" required>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control" name="description" id="description" rows="4">{{ old('description', optional($recipe ?? null)->description) }}</textarea>
</div>

<div class="form-group">
    <label for="notes">Notes</label>
    <textarea class="form-control" name="notes" id="notes" rows="4">{{ old('notes', optional($recipe ?? null)->notes) }}</textarea>
</div>

<div class="d-flex flex-wrap justify-content-between mt-3">
    <a href="{{ route('recipes.index') }}" class="btn btn-secondary mb-2">Cancel</a>
    <button type="submit" class="btn btn-primary mb-2">{{ $buttonText }}</button>
</div>
