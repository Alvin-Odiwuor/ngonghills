@csrf

<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', optional($ingredient ?? null)->name) }}" required>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="unit">Unit <span class="text-danger">*</span></label>
            <select class="form-control" name="unit" id="unit" required>
                @foreach(['g', 'ml', 'kg', 'L', 'pcs'] as $unit)
                    <option value="{{ $unit }}" {{ old('unit', optional($ingredient ?? null)->unit ?? 'pcs') === $unit ? 'selected' : '' }}>{{ $unit }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select class="form-control" name="status" id="status" required>
                <option value="active" {{ old('status', optional($ingredient ?? null)->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', optional($ingredient ?? null)->status ?? 'active') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="current_stock">Current Stock <span class="text-danger">*</span></label>
            <input type="number" step="0.001" min="0" class="form-control" name="current_stock" id="current_stock" value="{{ old('current_stock', optional($ingredient ?? null)->current_stock ?? 0) }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="reorder_level">Reorder Level <span class="text-danger">*</span></label>
            <input type="number" step="0.001" min="0" class="form-control" name="reorder_level" id="reorder_level" value="{{ old('reorder_level', optional($ingredient ?? null)->reorder_level ?? 0) }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="cost_per_unit">Cost Per Unit <span class="text-danger">*</span></label>
            <input type="number" step="0.0001" min="0" class="form-control" name="cost_per_unit" id="cost_per_unit" value="{{ old('cost_per_unit', optional($ingredient ?? null)->cost_per_unit ?? 0) }}" required>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control" name="description" id="description" rows="4">{{ old('description', optional($ingredient ?? null)->description) }}</textarea>
</div>

<div class="d-flex flex-wrap justify-content-between mt-3">
    <a href="{{ route('ingredients.index') }}" class="btn btn-secondary mb-2">Cancel</a>
    <button type="submit" class="btn btn-primary mb-2">{{ $buttonText }}</button>
</div>
