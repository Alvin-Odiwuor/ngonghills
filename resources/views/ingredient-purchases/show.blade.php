@extends('layouts.app')

@section('title', 'Ingredient Purchase Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('ingredient-purchases.index') }}">Ingredient Purchases</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Ingredient Purchase Details</h4>
                <a href="{{ route('ingredient-purchases.edit', $ingredientPurchase) }}" class="btn btn-primary">Edit</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Ingredient:</strong>
                        <div>{{ optional($ingredientPurchase->ingredient)->name ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Supplier:</strong>
                        <div>{{ optional($ingredientPurchase->supplier)->supplier_name ?? '-' }}</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Quantity:</strong>
                        <div>{{ number_format((float) $ingredientPurchase->quantity, 3) }}</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Unit Cost:</strong>
                        <div>{{ number_format((float) $ingredientPurchase->unit_cost, 4) }}</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Total Cost:</strong>
                        <div>{{ number_format((float) $ingredientPurchase->total_cost, 4) }}</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Purchase Date:</strong>
                        <div>{{ optional($ingredientPurchase->purchase_date)->format('d M, Y') ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Invoice Number:</strong>
                        <div>{{ $ingredientPurchase->invoice_number }}</div>
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Notes:</strong>
                        <div>{{ $ingredientPurchase->notes ?: '-' }}</div>
                    </div>
                </div>

                <a href="{{ route('ingredient-purchases.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection
