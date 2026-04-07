@extends('layouts.app')

@section('title', 'Loyalty Account Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('loyalty-accounts.index') }}">Loyalty Accounts</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Loyalty Account Details</h4>
                <a href="{{ route('loyalty-accounts.edit', $loyaltyAccount) }}" class="btn btn-primary">Edit</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Customer:</strong>
                        <div>{{ optional($loyaltyAccount->customer)->customer_name }}</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Tier:</strong>
                        <div>{{ $loyaltyAccount->tier }}</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Status:</strong>
                        <div>{{ ucfirst($loyaltyAccount->status) }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Points Balance:</strong>
                        <div>{{ number_format($loyaltyAccount->points_balance) }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Total Earned:</strong>
                        <div>{{ number_format($loyaltyAccount->total_points_earned) }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Total Redeemed:</strong>
                        <div>{{ number_format($loyaltyAccount->total_points_redeemed) }}</div>
                    </div>
                </div>

                <a href="{{ route('loyalty-accounts.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection
