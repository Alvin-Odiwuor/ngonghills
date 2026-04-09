@extends('layouts.app')

@section('title', 'Ingredient Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('ingredients.index') }}">Ingredients</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Ingredient Details</h4>
                <a href="{{ route('ingredients.edit', $ingredient) }}" class="btn btn-primary">Edit</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Name:</strong>
                        <div>{{ $ingredient->name }}</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Unit:</strong>
                        <div>{{ $ingredient->unit }}</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Status:</strong>
                        <div>{{ ucfirst($ingredient->status) }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Current Stock:</strong>
                        <div>{{ number_format((float) $ingredient->current_stock, 3) }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Reorder Level:</strong>
                        <div>{{ number_format((float) $ingredient->reorder_level, 3) }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Cost Per Unit:</strong>
                        <div>{{ number_format((float) $ingredient->cost_per_unit, 4) }}</div>
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Description:</strong>
                        <div>{{ $ingredient->description ?: '-' }}</div>
                    </div>
                </div>

                <a href="{{ route('ingredients.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection
