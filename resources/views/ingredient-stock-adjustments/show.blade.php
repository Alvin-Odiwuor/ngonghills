@extends('layouts.app')

@section('title', 'Ingredient Adjustment Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('ingredient-stock-adjustments.index') }}">Ingredient Adjustments</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Ingredient Adjustment Details</h4>
                <a href="{{ route('ingredient-stock-adjustments.edit', $ingredientStockAdjustment) }}" class="btn btn-primary">Edit</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Ingredient:</strong>
                        <div>{{ optional($ingredientStockAdjustment->ingredient)->name ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Outlet:</strong>
                        <div>{{ optional($ingredientStockAdjustment->outlet)->name ?? '-' }}</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Type:</strong>
                        <div>{{ ucfirst($ingredientStockAdjustment->adjustment_type) }}</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Quantity:</strong>
                        <div>{{ number_format((float) $ingredientStockAdjustment->quantity, 3) }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Reason:</strong>
                        <div>{{ ucfirst($ingredientStockAdjustment->reason) }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Reference:</strong>
                        <div>
                            @if($ingredientStockAdjustment->reference_type)
                                {{ class_basename($ingredientStockAdjustment->reference_type) }} #{{ $ingredientStockAdjustment->reference_id }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Adjusted By:</strong>
                        <div>{{ optional($ingredientStockAdjustment->user)->name ?? '-' }}</div>
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Notes:</strong>
                        <div>{{ $ingredientStockAdjustment->notes ?: '-' }}</div>
                    </div>
                </div>

                <a href="{{ route('ingredient-stock-adjustments.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection
