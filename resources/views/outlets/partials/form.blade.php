@csrf

<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', optional($outlet ?? null)->name) }}" required>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="type">Type <span class="text-danger">*</span></label>
            <select class="form-control" name="type" id="type" required>
                <option value="restaurant" {{ old('type', optional($outlet ?? null)->type ?? 'restaurant') === 'restaurant' ? 'selected' : '' }}>Restaurant</option>
                <option value="bar" {{ old('type', optional($outlet ?? null)->type ?? 'restaurant') === 'bar' ? 'selected' : '' }}>Bar</option>
                <option value="spa" {{ old('type', optional($outlet ?? null)->type ?? 'restaurant') === 'spa' ? 'selected' : '' }}>Spa</option>
                <option value="room_service" {{ old('type', optional($outlet ?? null)->type ?? 'restaurant') === 'room_service' ? 'selected' : '' }}>Room Service</option>
                <option value="shop" {{ old('type', optional($outlet ?? null)->type ?? 'restaurant') === 'shop' ? 'selected' : '' }}>Shop</option>
                <option value="events" {{ old('type', optional($outlet ?? null)->type ?? 'restaurant') === 'events' ? 'selected' : '' }}>Events</option>
                <option value="other" {{ old('type', optional($outlet ?? null)->type ?? 'restaurant') === 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select class="form-control" name="status" id="status" required>
                <option value="active" {{ old('status', optional($outlet ?? null)->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', optional($outlet ?? null)->status ?? 'active') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="location">Location / Floor <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="location" id="location" value="{{ old('location', optional($outlet ?? null)->location) }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="manager_id">Manager <span class="text-danger">*</span></label>
            <select class="form-control" name="manager_id" id="manager_id" required>
                <option value="">Select manager</option>
                @foreach(($managers ?? collect()) as $manager)
                    <option value="{{ $manager->id }}" {{ (string) old('manager_id', optional($outlet ?? null)->manager_id) === (string) $manager->id ? 'selected' : '' }}>
                        {{ $manager->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="phone_extension">Phone Extension</label>
            <input type="text" class="form-control" name="phone_extension" id="phone_extension" value="{{ old('phone_extension', optional($outlet ?? null)->phone_extension) }}">
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="opening_time">Opening Time <span class="text-danger">*</span></label>
            <input type="time" class="form-control" name="opening_time" id="opening_time" value="{{ old('opening_time', optional(optional($outlet ?? null)->opening_time)->format('H:i') ?? '08:00') }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="closing_time">Closing Time <span class="text-danger">*</span></label>
            <input type="time" class="form-control" name="closing_time" id="closing_time" value="{{ old('closing_time', optional(optional($outlet ?? null)->closing_time)->format('H:i') ?? '22:00') }}" required>
        </div>
    </div>
</div>

<div class="d-flex flex-wrap justify-content-between mt-3">
    <a href="{{ route('outlets.index') }}" class="btn btn-secondary mb-2">Cancel</a>
    <button type="submit" class="btn btn-primary mb-2">{{ $buttonText }}</button>
</div>
