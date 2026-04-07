@extends('layouts.app')

@section('title', 'Point Transaction Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('point-transactions.index') }}">Point Transactions</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Point Transaction Details</h4>
                <a href="{{ route('point-transactions.edit', $pointTransaction) }}" class="btn btn-primary">Edit</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Loyalty Account:</strong>
                        <div>
                            #{{ optional($pointTransaction->loyaltyAccount)->id }}
                            @if(optional(optional($pointTransaction->loyaltyAccount)->customer)->customer_name)
                                - {{ optional($pointTransaction->loyaltyAccount->customer)->customer_name }}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Type:</strong>
                        <div>{{ ucfirst($pointTransaction->type) }}</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Points:</strong>
                        <div class="{{ $pointTransaction->points >= 0 ? 'text-success' : 'text-danger' }} font-weight-bold">
                            {{ $pointTransaction->points >= 0 ? '+' : '' }}{{ $pointTransaction->points }}
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Order:</strong>
                        <div>{{ optional($pointTransaction->order)->reference ?? 'No linked purchase' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Expires At:</strong>
                        <div>{{ optional($pointTransaction->expires_at)->format('d M, Y') ?? '-' }}</div>
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Description:</strong>
                        <div>{{ $pointTransaction->description ?? '-' }}</div>
                    </div>
                </div>

                <a href="{{ route('point-transactions.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection
