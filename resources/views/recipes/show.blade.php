@extends('layouts.app')

@section('title', 'Recipe Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('recipes.index') }}">Recipes</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Recipe Details</h4>
                <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-primary">Edit</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Name:</strong>
                        <div>{{ $recipe->name }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Product:</strong>
                        <div>{{ optional($recipe->product)->product_name ?? '-' }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Yield Quantity:</strong>
                        <div>{{ number_format((float) $recipe->yield_quantity, 3) }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Status:</strong>
                        <div>{{ ucfirst($recipe->status) }}</div>
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Description:</strong>
                        <div>{{ $recipe->description ?: '-' }}</div>
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Notes:</strong>
                        <div>{{ $recipe->notes ?: '-' }}</div>
                    </div>
                </div>

                <a href="{{ route('recipes.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection
