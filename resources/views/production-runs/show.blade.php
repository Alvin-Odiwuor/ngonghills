@extends('layouts.app')

@section('title', 'Production Run Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('production-runs.index') }}">Production Runs</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Production Run Details</h4>
                <a href="{{ route('production-runs.edit', $productionRun) }}" class="btn btn-primary">Edit</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <strong>Batch Number:</strong>
                        <div>{{ $productionRun->batch_number }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Status:</strong>
                        <div>{{ ucfirst($productionRun->status) }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Production Date:</strong>
                        <div>{{ optional($productionRun->production_date)->format('d M, Y') ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Recipe:</strong>
                        <div>{{ optional($productionRun->recipe)->name ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Product:</strong>
                        <div>{{ optional($productionRun->product)->product_name ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Outlet:</strong>
                        <div>{{ optional($productionRun->outlet)->name ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Produced By:</strong>
                        <div>{{ optional($productionRun->user)->name ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Quantity Produced:</strong>
                        <div>{{ number_format((float) $productionRun->quantity_produced, 3) }}</div>
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Notes:</strong>
                        <div>{{ $productionRun->notes ?: '-' }}</div>
                    </div>
                </div>

                <a href="{{ route('production-runs.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection
