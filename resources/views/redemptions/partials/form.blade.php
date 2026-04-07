@csrf

<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="loyalty_account_id">Loyalty Account <span class="text-danger">*</span></label>
            <select class="form-control" name="loyalty_account_id" id="loyalty_account_id" required>
                <option value="">Select loyalty account</option>
                @foreach($loyaltyAccounts as $account)
                    <option value="{{ $account->id }}" {{ (string) old('loyalty_account_id', optional($redemption ?? null)->loyalty_account_id) === (string) $account->id ? 'selected' : '' }}>
                        {{ $account->account_number }} - {{ optional($account->customer)->customer_name ?? 'No customer' }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="reward_id">Reward <span class="text-danger">*</span></label>
            <select class="form-control" name="reward_id" id="reward_id" required>
                <option value="">Select reward</option>
                @foreach($rewards as $rewardOption)
                    <option value="{{ $rewardOption->id }}" {{ (string) old('reward_id', optional($redemption ?? null)->reward_id) === (string) $rewardOption->id ? 'selected' : '' }}>
                        {{ $rewardOption->name }} ({{ number_format($rewardOption->points_required) }} pts)
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="points_used">Points Used <span class="text-danger">*</span></label>
            <input type="number" min="1" class="form-control" name="points_used" id="points_used" value="{{ old('points_used', optional($redemption ?? null)->points_used ?? 1) }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select class="form-control" name="status" id="status" required>
                @foreach(['pending', 'approved', 'rejected', 'used'] as $status)
                    <option value="{{ $status }}" {{ old('status', optional($redemption ?? null)->status ?? 'pending') === $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="redeemed_at">Redeemed At</label>
            <input type="datetime-local" class="form-control" name="redeemed_at" id="redeemed_at" value="{{ old('redeemed_at', optional(optional($redemption ?? null)->redeemed_at)->format('Y-m-d\\TH:i')) }}">
        </div>
    </div>
</div>

<div class="form-group">
    <label for="notes">Notes</label>
    <textarea class="form-control" name="notes" id="notes" rows="4">{{ old('notes', optional($redemption ?? null)->notes) }}</textarea>
</div>

<div class="d-flex flex-wrap justify-content-between mt-3">
    <a href="{{ route('redemptions.index') }}" class="btn btn-secondary mb-2">Cancel</a>
    <button type="submit" class="btn btn-primary mb-2">{{ $buttonText }}</button>
</div>
