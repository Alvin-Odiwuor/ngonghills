@extends('layouts.app')

@section('title', 'Reward Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('rewards.index') }}">Rewards</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Reward Details</h4>
                <a href="{{ route('rewards.edit', $reward) }}" class="btn btn-primary">Edit</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Name:</strong>
                        <div>{{ $reward->name }}</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Type:</strong>
                        <div>{{ ucfirst(str_replace('_', ' ', $reward->reward_type)) }}</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Status:</strong>
                        <div>{{ $reward->is_active ? 'Active' : 'Inactive' }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Points Required:</strong>
                        <div>{{ number_format($reward->points_required) }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Reward Value:</strong>
                        <div>{{ $reward->reward_value ?? '-' }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Linked Product:</strong>
                        <div>{{ optional($reward->product)->product_name ?? '-' }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Stock:</strong>
                        <div>{{ is_null($reward->stock) ? 'Unlimited' : $reward->stock }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Expires At:</strong>
                        <div>{{ optional($reward->expires_at)->format('d M, Y') ?? '-' }}</div>
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Description:</strong>
                        <div>{{ $reward->description ?? '-' }}</div>
                    </div>
                </div>

                <a href="{{ route('rewards.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection
