@csrf

<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="loyalty_account_id">Loyalty Account <span class="text-danger">*</span></label>
            <select class="form-control" name="loyalty_account_id" id="loyalty_account_id" required>
                @foreach($loyaltyAccounts as $account)
                    <option value="{{ $account->id }}" {{ old('loyalty_account_id', optional($pointTransaction ?? null)->loyalty_account_id) == $account->id ? 'selected' : '' }}>
                        #{{ $account->id }} - {{ optional($account->customer)->customer_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="type">Type <span class="text-danger">*</span></label>
            <select class="form-control" name="type" id="type" required>
                @foreach(['earn', 'redeem', 'expire', 'adjust'] as $type)
                    <option value="{{ $type }}" {{ old('type', optional($pointTransaction ?? null)->type ?? 'earn') === $type ? 'selected' : '' }}>
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="points">Points <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="points" id="points" value="{{ old('points', optional($pointTransaction ?? null)->points ?? 10) }}" required>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="sale_id">Sale</label>
            <select class="form-control" name="sale_id" id="sale_id">
                <option value="">No linked sale</option>
                @foreach($sales as $sale)
                    <option value="{{ $sale->id }}" {{ (string) old('sale_id', optional($pointTransaction ?? null)->sale_id) === (string) $sale->id ? 'selected' : '' }}>
                        #{{ $sale->id }} - {{ $sale->reference }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="expires_at">Expires At</label>
            <input type="date" class="form-control" name="expires_at" id="expires_at" value="{{ old('expires_at', optional(optional($pointTransaction ?? null)->expires_at)->format('Y-m-d')) }}">
        </div>
    </div>
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control" name="description" id="description" rows="4">{{ old('description', optional($pointTransaction ?? null)->description) }}</textarea>
</div>

<div class="d-flex flex-wrap justify-content-between mt-3">
    <a href="{{ route('point-transactions.index') }}" class="btn btn-secondary mb-2">Cancel</a>
    <button type="submit" class="btn btn-primary mb-2">{{ $buttonText }}</button>
</div>
