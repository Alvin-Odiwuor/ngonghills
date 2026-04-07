@csrf

<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="customer_id">Customer <span class="text-danger">*</span></label>
            <select class="form-control" name="customer_id" id="customer_id" required>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ old('customer_id', optional($loyaltyAccount ?? null)->customer_id) == $customer->id ? 'selected' : '' }}>
                        {{ $customer->customer_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="tier">Tier <span class="text-danger">*</span></label>
            <select class="form-control" name="tier" id="tier" required>
                @foreach(['Bronze', 'Silver', 'Gold'] as $tier)
                    <option value="{{ $tier }}" {{ old('tier', optional($loyaltyAccount ?? null)->tier ?? 'Bronze') === $tier ? 'selected' : '' }}>
                        {{ $tier }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select class="form-control" name="status" id="status" required>
                @foreach(['active', 'suspended'] as $status)
                    <option value="{{ $status }}" {{ old('status', optional($loyaltyAccount ?? null)->status ?? 'active') === $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="points_balance">Points Balance <span class="text-danger">*</span></label>
            <input type="number" min="0" class="form-control" name="points_balance" id="points_balance" value="{{ old('points_balance', optional($loyaltyAccount ?? null)->points_balance ?? 0) }}" required>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="total_points_earned">Total Points Earned <span class="text-danger">*</span></label>
            <input type="number" min="0" class="form-control" name="total_points_earned" id="total_points_earned" value="{{ old('total_points_earned', optional($loyaltyAccount ?? null)->total_points_earned ?? 0) }}" required>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="total_points_redeemed">Total Points Redeemed <span class="text-danger">*</span></label>
            <input type="number" min="0" class="form-control" name="total_points_redeemed" id="total_points_redeemed" value="{{ old('total_points_redeemed', optional($loyaltyAccount ?? null)->total_points_redeemed ?? 0) }}" required>
        </div>
    </div>
</div>

<div class="d-flex flex-wrap justify-content-between mt-3">
    <a href="{{ route('loyalty-accounts.index') }}" class="btn btn-secondary mb-2">Cancel</a>
    <button type="submit" class="btn btn-primary mb-2">{{ $buttonText }}</button>
</div>
