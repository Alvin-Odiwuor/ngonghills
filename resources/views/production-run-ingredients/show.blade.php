@extends('layouts.app')

@section('title', 'Production Run Ingredient Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('production-run-ingredients.index') }}">Production Run Ingredients</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Consumption Log Details</h4>
                <a href="{{ route('production-run-ingredients.edit', $productionRunIngredient) }}" class="btn btn-primary">Edit</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Production Batch:</strong>
                        <div>{{ optional($productionRunIngredient->productionRun)->batch_number ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Ingredient:</strong>
                        <div>{{ optional($productionRunIngredient->ingredient)->name ?? '-' }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Quantity Used:</strong>
                        <div>{{ number_format((float) $productionRunIngredient->quantity_used, 3) }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Unit Cost At Time:</strong>
                        <div>{{ number_format((float) $productionRunIngredient->unit_cost_at_time, 4) }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Total Cost:</strong>
                        <div>{{ number_format((float) $productionRunIngredient->total_cost, 4) }}</div>
                    </div>
                </div>

                <a href="{{ route('production-run-ingredients.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection
