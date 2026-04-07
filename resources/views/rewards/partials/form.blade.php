@csrf

<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', optional($reward ?? null)->name) }}" required>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="reward_type">Reward Type <span class="text-danger">*</span></label>
            <select class="form-control" name="reward_type" id="reward_type" required>
                @foreach(['discount', 'free_product', 'voucher','points','early access'] as $type)
                    <option value="{{ $type }}" {{ old('reward_type', optional($reward ?? null)->reward_type ?? 'discount') === $type ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $type)) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="points_required">Points Required <span class="text-danger">*</span></label>
            <input type="number" min="1" class="form-control" name="points_required" id="points_required" value="{{ old('points_required', optional($reward ?? null)->points_required ?? 100) }}" required>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="reward_value">Reward Value</label>
            <input type="text" class="form-control" name="reward_value" id="reward_value" value="{{ old('reward_value', optional($reward ?? null)->reward_value) }}" placeholder="e.g. 10, PRD_0001, VOUCHER123">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" min="0" class="form-control" name="stock" id="stock" value="{{ old('stock', optional($reward ?? null)->stock) }}" placeholder="Leave blank for unlimited">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="expires_at">Expires At</label>
            <input type="date" class="form-control" name="expires_at" id="expires_at" value="{{ old('expires_at', optional(optional($reward ?? null)->expires_at)->format('Y-m-d')) }}">
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="is_active">Status <span class="text-danger">*</span></label>
            <select class="form-control" name="is_active" id="is_active" required>
                <option value="1" {{ (string) old('is_active', optional($reward ?? null)->is_active ?? 1) === '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ (string) old('is_active', optional($reward ?? null)->is_active ?? 1) === '0' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control" name="description" id="description" rows="4">{{ old('description', optional($reward ?? null)->description) }}</textarea>
</div>

<div class="d-flex flex-wrap justify-content-between mt-3">
    <a href="{{ route('rewards.index') }}" class="btn btn-secondary mb-2">Cancel</a>
    <button type="submit" class="btn btn-primary mb-2">{{ $buttonText }}</button>
</div>
