@extends('layouts.app')

@section('title', 'Redemption Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('redemptions.index') }}">Redemptions</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Redemption #{{ $redemption->id }}</h4>
                <div>
                    <a href="{{ route('redemptions.edit', $redemption) }}" class="btn btn-primary">Edit</a>
                    <a href="{{ route('redemptions.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Loyalty Account:</strong><br>
                        {{ optional($redemption->loyaltyAccount)->account_number ?? '-' }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Customer:</strong><br>
                        {{ optional(optional($redemption->loyaltyAccount)->customer)->customer_name ?? '-' }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Reward:</strong><br>
                        {{ optional($redemption->reward)->name ?? '-' }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Points Used:</strong><br>
                        {{ number_format($redemption->points_used) }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Status:</strong><br>
                        {{ ucfirst($redemption->status) }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Redeemed At:</strong><br>
                        {{ optional($redemption->redeemed_at)->format('d M, Y H:i') ?? '-' }}
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Notes:</strong><br>
                        {{ $redemption->notes ?: '-' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
